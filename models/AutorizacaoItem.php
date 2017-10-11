<?php

namespace app\models;

/**
 * This is the model class for table "autorizacao_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AutorizacaoAtribuicoes[] $autorizacaoAtribuicoes
 * @property Usuario[] $users
 * @property AutorizacaoRegras $ruleName
 * @property AutorizacaoItemHierarquia[] $autorizacaoItemHierarquias
 */
class AutorizacaoItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'autorizacao_item';
    }
    
  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutorizacaoAtribuicoes()
    {
        return $this->hasMany(AutorizacaoAtribuicoes::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Usuario::className(), ['id' => 'user_id'])->viaTable('autorizacao_atribuicoes', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AutorizacaoRegras::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutorizacaoItemHierarquias()
    {
        return $this->hasMany(AutorizacaoItemHierarquia::className(), ['child' => 'name']);
    }

                                                            }
