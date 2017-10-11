<?php

namespace app\models;

/**
 * This is the model class for table "autorizacao_item_hierarquia".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AutorizacaoItem $parent0
 * @property AutorizacaoItem $child0
 */
class AutorizacaoItemHierarquia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autorizacao_item_hierarquia';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AutorizacaoItem::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AutorizacaoItem::className(), ['name' => 'child']);
    }

                    }
