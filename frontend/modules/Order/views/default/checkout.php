<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Order $model */
/** @var yii\widgets\ActiveForm $form */

// dd($cartItems);
?>

<section class="blog about-blog">
    <div class="container">
        <div class="blog-bradcrum">
            <span><a href="<?= Url::home() ?>">Home</a></span>
            <span class="devider">/</span>
            <span><a href="#">Checkout</a></span>
        </div>
        <div class="blog-heading about-heading">
            <h1 class="heading">Checkout</h1>
        </div>
    </div>
</section>

<section class="checkout product footer-padding">
    <div class="container">
        <div class="checkout-section">
            <?php $form = ActiveForm::begin([
                'id' => 'checkout-form',
                'action' => 'create',
                'options' => ['class' => 'checkout-form']
            ]); ?>

            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="checkout-wrapper">
                        <a href="<?= Url::to(['site/login']) ?>" class="shop-btn">Войдите в свой аккаунт</a>
                        <div class="account-section billing-section">
                            <h5 class="wrapper-heading">Данные для доставки</h5>
                            <div class="review-form">
                                <div class="account-inner-form">
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'customer_name', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->textInput([
                                                    'class' => 'form-control',
                                                    'placeholder' => '1',
                                                    'id' => 'fname'
                                                ])->label('First Name*', ['class' => 'form-label']) ?>
                                    </div>
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'customer_last_name', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->textInput([
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Last Name',
                                                    'id' => 'lname'
                                                ])->label('Last Name*', ['class' => 'form-label']) ?>
                                    </div>
                                </div>

                                <div class="account-inner-form">
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'customer_email', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->textInput([
                                                    'class' => 'form-control',
                                                    'placeholder' => 'user@gmail.com',
                                                    'type' => 'email',
                                                    'id' => 'email'
                                                ])->label('Email*', ['class' => 'form-label']) ?>
                                    </div>
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'customer_phone', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->textInput([
                                                    'class' => 'form-control',
                                                    'placeholder' => '+880388**0899',
                                                    'type' => 'tel',
                                                    'id' => 'phone'
                                                ])->label('Phone*', ['class' => 'form-label']) ?>
                                    </div>
                                </div>

                                <div class="review-form-name">
                                    <?= $form->field($model, 'delivery_country', [
                                        'template' => '{label}{input}{error}',
                                        'options' => ['class' => 'form-group']
                                    ])->dropDownList([
                                                'Bangladesh' => 'Bangladesh',
                                                'United States' => 'United States',
                                                'United Kingdom' => 'United Kingdom'
                                            ], [
                                                'class' => 'form-select',
                                                'prompt' => 'Choose...',
                                                'id' => 'country'
                                            ])->label('Country*', ['class' => 'form-label']) ?>
                                </div>

                                <div class="review-form-name address-form">
                                    <?= $form->field($model, 'delivery_address', [
                                        'template' => '{label}{input}{error}',
                                        'options' => ['class' => 'form-group']
                                    ])->textInput([
                                                'class' => 'form-control',
                                                'placeholder' => 'Enter your Address',
                                                'id' => 'address'
                                            ])->label('Address*', ['class' => 'form-label']) ?>
                                </div>

                                <div class="account-inner-form city-inner-form">
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'delivery_city', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->dropDownList([
                                                    'Newyork' => 'Newyork',
                                                    'Dhaka' => 'Dhaka',
                                                    'London' => 'London'
                                                ], [
                                                    'class' => 'form-select',
                                                    'prompt' => 'Choose...',
                                                    'id' => 'city'
                                                ])->label('Town / City*', ['class' => 'form-label']) ?>
                                    </div>
                                    <div class="review-form-name">
                                        <?= $form->field($model, 'delivery_postcode', [
                                            'template' => '{label}{input}{error}',
                                            'options' => ['class' => 'form-group']
                                        ])->textInput([
                                                    'class' => 'form-control',
                                                    'placeholder' => '0000',
                                                    'type' => 'number',
                                                    'id' => 'number'
                                                ])->label('Postcode / ZIP*', ['class' => 'form-label']) ?>
                                    </div>
                                </div>

                                <div class="review-form-name checkbox">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="account">
                                        <label for="account" class="form-label">
                                            Create an account?
                                        </label>
                                    </div>
                                </div>

                                <div class="review-form-name shipping">
                                    <h5 class="wrapper-heading">Shipping Address</h5>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="remember">
                                        <label for="remember" class="form-label">
                                            Same as billing address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="checkout-wrapper">
                        <a href="#" class="shop-btn">Enter Coupon Code</a>
                        <div class="account-section billing-section">
                            <h5 class="wrapper-heading">Order Summary</h5>
                            <div class="order-summery">
                                <div class="subtotal product-total">
                                    <h5 class="wrapper-heading">PRODUCT</h5>
                                    <h5 class="wrapper-heading">TOTAL</h5>
                                </div>
                                <hr>
                                <div class="subtotal product-total">
                                    <?php if (empty($cartItems)): ?>
                                        <div class="empty-cart">
                                            <h3>Ваша корзина пуста</h3>
                                            <p>Продолжите покупки и положите товар в корзину</p>
                                            <a href="<?= Url::to(['/shop/default/index']) ?>" class="shop-btn">Продолжить
                                                покупки</a>
                                        </div>
                                    <?php else: ?>
                                        <ul class="product-list">
                                            <?php foreach ($cartItems as $item): ?>
                                                <li>
                                                    <div class="product-info">
                                                        <h5 class="wrapper-heading"><?= $item->product->name ?></h5>
                                                        <p class="paragraph"><?= (int)$item->product->length ?>x<?=(int)$item->product->width ?>x<?=(int)$item->product->height ?>
                                                            
                                                        </p>
                                                    </div>
                                                    <div class="price">
                                                        <h5 class="wrapper-heading"><?= $item->product->price ?></h5>
                                                    </div>
                                                </li>

                                            </ul>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </div>
                                <hr>
                                <div class="subtotal product-total">
                                    <h5 class="wrapper-heading">SUBTOTAL</h5>
                                    <h5 class="wrapper-heading"><?= $totalAmount ?></h5>
                                </div>
                                <div class="subtotal product-total">
                                    <ul class="product-list">
                                        <li>
                                            <div class="product-info">
                                                <p class="paragraph">SHIPPING</p>
                                                <h5 class="wrapper-heading">
                                                    <?= $deliveryMethod ? $deliveryMethod->name : 'Standard Shipping' ?>
                                                </h5>
                                            </div>
                                            <div class="price">
                                                <h5 class="wrapper-heading">
                                                    <?php if ($deliveryMethod->price > 0): ?>
                                                        +$<?= number_format($deliveryMethod->price, 2) ?>
                                                    <?php else: ?>
                                                        FREE
                                                    <?php endif; ?>
                                                </h5>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="subtotal total">
                                    <h5 class="wrapper-heading">TOTAL</h5>
                                    <h5 class="wrapper-heading price">$<?= number_format($totalAmount, 2) ?></h5>
                                </div>

                                <div class="subtotal payment-type">
                                    <?php foreach ($paymentMethods as $payment): ?>
                                        <div class="checkbox-item">
                                            <?= $form->field($model, 'payment_method', [
                                                'template' => '{input}',
                                                'options' => ['class' => 'form-group']
                                            ])->radio([
                                                        'value' => $payment->code,
                                                        'id' => 'payment-' . $payment->code,
                                                        'uncheck' => null,
                                                        'data-fee' => $payment->fee_percent,
                                                        'data-fee-fixed' => $payment->fee_fixed
                                                    ], false) ?>
                                            <div class="payment-method">
                                                <h5 class="wrapper-heading">
                                                    <?= $payment->name ?>
                                                    <?php if ($payment->fee_percent > 0 || $payment->fee_fixed > 0): ?>
                                                        <small class="fee-info">
                                                            (<?php
                                                            if ($payment->fee_fixed > 0 && $payment->fee_percent > 0) {
                                                                echo '+$' . $payment->fee_fixed . ' + ' . $payment->fee_percent . '%';
                                                            } elseif ($payment->fee_fixed > 0) {
                                                                echo '+$' . $payment->fee_fixed;
                                                            } elseif ($payment->fee_percent > 0) {
                                                                echo '+' . $payment->fee_percent . '%';
                                                            }
                                                            ?>)
                                                        </small>
                                                    <?php endif; ?>
                                                </h5>
                                                <?php if (!empty($payment->description)): ?>
                                                    <p class="paragraph"><?= $payment->description ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($payment->instructions)): ?>
                                                    <div class="payment-instructions">
                                                        <span class="inner-text"><?= $payment->instructions ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?= Html::submitButton('Place Order Now', [
                                    'class' => 'shop-btn',
                                    'name' => 'submit-button'
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>
<?php

// JavaScript для пересчета общей суммы при выборе способа оплаты с комиссией
$this->registerJs(<<<JS
    $(document).on('change', 'input[name="Order[payment_method]"]', function() {
        var subtotal = $totalAmount; // PHP переменная с суммой товаров
        var deliveryPrice = $deliveryMethod->price; // PHP переменная со стоимостью доставки
        var feePercent = $(this).data('fee') || 0;
        var feeFixed = $(this).data('fee-fixed') || 0;
        
        var feeAmount = (subtotal * feePercent / 100) + feeFixed;
        var totalAmount = subtotal + deliveryPrice + feeAmount;
        
        $('.total .price').text('$' + totalAmount.toFixed(2));
        
        // Показываем/скрываем информацию о комиссии
        $('.fee-info').hide();
        $(this).closest('.checkbox-item').find('.fee-info').show();
    });
JS
);
?>
<?php
// JavaScript для обработки одинаковых адресов доставки и оплаты
$this->registerJs(<<<JS
    $('#remember').change(function() {
        if(this.checked) {
            // Копируем данные из billing в shipping
            // Здесь можно добавить логику копирования полей
        }
    });
JS
);
?>