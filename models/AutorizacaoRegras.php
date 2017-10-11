<?php

namespace app\models;

/**
 * This is the model class for table "autorizacao_regras".
 *
 * @property string $name
 * @property string $description
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AutorizacaoItem[] $autorizacaoItems
 */
class AutorizacaoRegras extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autorizacao_regras';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description', 'data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutorizacaoItems()
    {
        return $this->hasMany(AutorizacaoItem::className(), ['rule_name' => 'name']);
    }

                                            }
