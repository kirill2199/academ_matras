<?php

namespace frontend\modules\Cart\controllers;


use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use frontend\modules\Cart\models\Cart;
use common\models\Product;

class DefaultController extends Controller 
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'update' => ['post'],
                    'delete' => ['post'],
                    'clear' => ['post'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if (in_array($action->id, ['add', 'update', 'delete', 'clear', 'mini-cart'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Страница корзины
     */
    public function actionIndex()
    {
        $cartItems = Cart::getCurrentCart();
        
        return $this->render('index', [
            'cartItems' => $cartItems,
            'totalAmount' => Cart::getTotalAmount(),
            'totalQuantity' => Cart::getTotalQuantity(),
        ]);
    }

    /**
     * Добавление товара в корзину (AJAX)
     */
    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $productId = Yii::$app->request->post('product_id');
        $quantity = Yii::$app->request->post('quantity', 1);
        $attributes = Yii::$app->request->post('attributes');
        
        $product = Product::findOne(['id'=>$productId]);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }
        
        // Проверяем наличие товара
        if ($product->quantity < $quantity) {
            return ['success' => false, 'message' => 'Not enough products in stock'];
        }
        
        // Получаем идентификатор корзины
        $cartIdentifier = Cart::getCartIdentifier();
        
        // Проверяем, есть ли уже такой товар в корзине
        $existingCartItem = Cart::find()
            ->where(['product_id' => $productId])
            ->andWhere($cartIdentifier)
            ->one();
        
        if ($existingCartItem) {
            // Обновляем количество существующего товара
            $existingCartItem->quantity += $quantity;
            if ($existingCartItem->save()) {
                return [
                    'success' => true,
                    'message' => 'Product quantity updated in cart',
                    'cartCount' => Cart::getTotalQuantity(),
                    'itemCount' => $existingCartItem->quantity
                ];
            }
        } else {
            // Добавляем новый товар в корзину
            $cartItem = new Cart();
            $cartItem->product_id = $productId;
            $cartItem->quantity = $quantity;
            $cartItem->price = $product->price;
            $cartItem->attributes = $attributes ? json_encode($attributes) : null;
            
            if (Yii::$app->user->id) {
                $cartItem->user_id = Yii::$app->user->id;
            } else {
                $cartItem->session_id = Yii::$app->session->get('cart_session_id');
            }
            
            if ($cartItem->save()) {
                return [
                    'success' => true,
                    'message' => 'Product added to cart',
                    'cartCount' => Cart::getTotalQuantity(),
                    'itemCount' => $cartItem->quantity
                ];
            }
        }
        
        return ['success' => false, 'message' => 'Error adding product to cart'];
    }

    /**
     * Обновление количества товара в корзине (AJAX)
     */
    public function actionUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $cartId = Yii::$app->request->post('cart_id');
        $quantity = Yii::$app->request->post('quantity');
        
        $cartItem = Cart::find()
            ->where(['id' => $cartId])
            ->andWhere(Cart::getCartIdentifier())
            ->one();
        
        if (!$cartItem) {
            return ['success' => false, 'message' => 'Cart item not found'];
        }
        
        // Проверяем наличие товара на складе
        if ($cartItem->product->quantity < $quantity) {
            return [
                'success' => false, 
                'message' => 'Not enough products in stock. Available: ' . $cartItem->product->quantity
            ];
        }
        
        if ($quantity <= 0) {
            return $this->actionDelete($cartId);
        }
        
        $cartItem->quantity = $quantity;
        if ($cartItem->save()) {
            return [
                'success' => true,
                'message' => 'Cart updated',
                'itemTotal' => Yii::$app->formatter->asCurrency($cartItem->getItemTotal()),
                'cartTotal' => Yii::$app->formatter->asCurrency(Cart::getTotalAmount()),
                'cartCount' => Cart::getTotalQuantity()
            ];
        }
        
        return ['success' => false, 'message' => 'Error updating cart'];
    }

    /**
     * Удаление товара из корзины (AJAX)
     */
    public function actionDelete($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!$id) {
            $id = Yii::$app->request->post('cart_id');
        }
        
        $cartItem = Cart::find()
            ->where(['id' => $id])
            ->andWhere(Cart::getCartIdentifier())
            ->one();
        
        if ($cartItem && $cartItem->delete()) {
            return [
                'success' => true,
                'message' => 'Product removed from cart',
                'cartTotal' => Yii::$app->formatter->asCurrency(Cart::getTotalAmount()),
                'cartCount' => Cart::getTotalQuantity()
            ];
        }
        
        return ['success' => false, 'message' => 'Error removing product from cart'];
    }

    /**
     * Очистка всей корзины (AJAX)
     */
    public function actionClear()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $deleted = Cart::deleteAll(Cart::getCartIdentifier());
        
        if ($deleted) {
            return [
                'success' => true,
                'message' => 'Cart cleared',
                'cartTotal' => Yii::$app->formatter->asCurrency(0),
                'cartCount' => 0
            ];
        }
        
        return ['success' => false, 'message' => 'Error clearing cart'];
    }

    

    /**
     * Мини-корзина для AJAX обновления
     */
    public function actionMiniCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $cartItems = Cart::getCurrentCart();
        $html = $this->renderPartial('_mini_cart', [
            'cartItems' => $cartItems,
            'totalAmount' => Cart::getTotalAmount(),
            'totalQuantity' => Cart::getTotalQuantity(),
        ]);
        
        return [
            'success' => true,
            'html' => $html,
            'cartCount' => Cart::getTotalQuantity(),
            'cartTotal' => Yii::$app->formatter->asCurrency(Cart::getTotalAmount())
        ];
    }
}