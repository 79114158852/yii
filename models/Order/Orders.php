<?php

namespace app\models\Order;

use app\models\History as ModelsHistory;
use Yii;
use \yii\db\ActiveRecord;
use app\models\Product\Products;
use app\models\History\History;


/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $customer Заказчик
 * @property string $title Наименование
 * @property int $product_id Продукт
 * @property string $phone Телефон
 * @property int|null $status_id Статус
 * @property float $price Цена
 * @property string $description Описание
 * @property string $created_at
 *
 * @property History[] $histories
 * @property Products $product
 * @property OrderStatus $status
 */
class Orders extends ActiveRecord
{   
    /**
     * values before saving to check for updates 
     */
    private $currentValues = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {



        return [
            [['customer', 'product_id', 'phone', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['product_id', 'status_id'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['customer'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['status_id'], 'exist', 'skipOnError' => false, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['status_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer' => 'Заказчик',
            'title' => 'Наименование',
            'product_id' => 'Продукт',
            'phone' => 'Телефон',
            'status_id' => 'Статус',
            'price' => 'Цена',
            'description' => 'Комментарий',
            'created_at' => 'Создан',
            'histories'   => 'История'
        ];
    }

    /**
     * Gets query for [[Histories]].
     *
     * @return \yii\db\ActiveQuery|HistoryQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::class, ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductsQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery|OrderStatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OrderStatus::class, ['id' => 'status_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }


    /**
     * Getting current values to check for updates 
    */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        foreach($this->attributeLabels() as $index => $label){

            $this->currentValues[$index] = $this->$index;

        }
        
        return true;
    }


    /**
     * 
     * Checking the attribute changes, 
     * Getting related tables name value
     * 
    */
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if(!$insert) {

            $allAttributes = $this->attributeLabels();

            $text = '';

            foreach($changedAttributes as $index => $value){

                if ($this->currentValues[$index] != $value){

                    if (strpos($index, '_id') !== false){
                        
                        $method = str_replace('_id', '', $index);

                        $value = $this->$method->name ?? $value;

                    } 

                    $text .= $allAttributes[$index].' -> '.$value.PHP_EOL;

                }

            }

            if ($text != ''){

                Yii::$app->db->createCommand()->insert('history', [
                    'order_id' => $this->id, 
                    'user_id' => Yii::$app->user->identity->getId(), 
                    'action' => Yii::$app->user->identity->username.PHP_EOL.$text
                ])->execute();

            }
            
        }
    }
}