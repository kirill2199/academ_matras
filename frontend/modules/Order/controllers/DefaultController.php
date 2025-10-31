<?php

namespace frontend\modules\Order\controllers;

use Yii;
use common\models\Order;
use frontend\modules\Order\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \frontend\modules\Cart\models\Cart;
use \common\models\Product;
use \common\models\DeliveryMethod;
use \common\models\PaymentMethod;
use \common\models\OrderItem;


/**
 * DefaultController implements the CRUD actions for Order model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCheckout()
    {
        $model = new Order();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $paymentMethods = PaymentMethod::find()
            ->where(['is_active' => true])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        $deliveryMethod = DeliveryMethod::find()
            ->where(['code' => 'courier'])
            ->one();

        return $this->render('checkout', [
            'model' => $model,
            'cartItems' => Cart::getCurrentCart(),
            'totalAmount' => Cart::getTotalAmount(),
            'totalQuantity' => Cart::getTotalQuantity(),
            'deliveryMethod' => $deliveryMethod,
            'paymentMethods' => $paymentMethods,
        ]);
    }
    /**
     * Creates a new Order model with order items.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->request->isPost && $model->load($this->request->post())) {

                // Получаем товары из корзины
                $cartItems = Cart::getCurrentCart();
                $totalAmount = Cart::getTotalAmount();

                if (empty($cartItems)) {
                    Yii::$app->session->setFlash('error', 'Ваша корзина пуста');
                    return $this->redirect(['checkout']);
                }

                // Устанавливаем обязательные поля заказа
                $model->number = $this->generateOrderNumber();
                $model->status = Order::STATUS_NEW; // Добавьте константу в модель Order
                $model->payment_status = Order::PAYMENT_STATUS_PENDING; // Добавьте константу в модель Order
                $model->subtotal = $totalAmount;
                $model->total = $totalAmount;

                // Добавляем стоимость доставки
                $deliveryMethod = DeliveryMethod::find()
                    ->where(['code' => 'courier'])
                    ->one();

                if ($deliveryMethod) {
                    $model->delivery_method = $deliveryMethod->code;
                    $model->delivery_price = $deliveryMethod->price;
                    $model->total += $deliveryMethod->price;
                }

                // Добавляем комиссию способа оплаты
                $paymentMethod = PaymentMethod::find()
                    ->where(['code' => $model->payment_method])
                    ->one();

                if ($paymentMethod) {
                    $paymentFee = ($totalAmount * $paymentMethod->fee_percent / 100) + $paymentMethod->fee_fixed;
                    $model->total += $paymentFee;
                }

                // Дополнительные поля
                $model->ip_address = Yii::$app->request->userIP;
                $model->user_agent = Yii::$app->request->userAgent;
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');

                if ($model->save()) {
                    // Создаем товары заказа
                    foreach ($cartItems as $cartItem) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $model->id;
                        $orderItem->product_id = $cartItem->product_id;
                        $orderItem->name = $cartItem->product->name;
                        $orderItem->sku = $cartItem->product->sku;
                        $orderItem->quantity = $cartItem->quantity;
                        $orderItem->price = $cartItem->product->price;
                        $orderItem->total = $cartItem->product->price * $cartItem->quantity;
                        $orderItem->weight = $cartItem->product->weight;
                        $orderItem->created_at = date('Y-m-d H:i:s');

                        // Сохраняем атрибуты товара если нужно
                        $attributes = [
                            'length' => $cartItem->product->length,
                            'width' => $cartItem->product->width,
                            'height' => $cartItem->product->height,
                        ];
                        $orderItem->attributes = json_encode($attributes);

                        if (!$orderItem->save()) {
                            throw new \Exception('Ошибка сохранения товара заказа: ' . json_encode($orderItem->errors));
                        }
                    }

                    // Очищаем корзину после успешного создания заказа
                    if (Cart::clearCart()) {
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'Ошибка при очистки корзины: ' . $e->getMessage());
                        return $this->redirect(['checkout']);
                    }



                    Yii::$app->session->setFlash('success', 'Заказ успешно создан!');
                    return $this->redirect(['view', 'id' => $model->id]);

                } else {
                    throw new \Exception('Ошибка сохранения заказа: ' . json_encode($model->errors));
                }
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Ошибка при создании заказа: ' . $e->getMessage());
            return $this->redirect(['checkout']);
        }

        // Если GET запрос или ошибка валидации
        return $this->redirect(['checkout']);
    }

    /**
     * Генерирует уникальный номер заказа
     * @return string
     */
    protected function generateOrderNumber()
    {
        $prefix = 'ORD';
        $timestamp = date('YmdHis');
        $random = mt_rand(1000, 9999);

        return $prefix . $timestamp . $random;
    }


    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
