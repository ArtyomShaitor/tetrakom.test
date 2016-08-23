<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property integer $id
 * @property string $phone_a
 * @property string $phone_b
 * @property string $begin_date
 * @property string $connection_date
 * @property string $finish_date
 * @property integer $direction
 * @property string $comment
 */
class Record extends \yii\db\ActiveRecord
{
    const INCOMING_CALL = 0;
    const OUTGOING_CALL = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_a', 'phone_b'], 'required'],
            [['begin_date', 'connection_date', 'finish_date'], 'safe'],
            [['direction'], 'integer'],
            [['comment'], 'string'],
            [['phone_a', 'phone_b'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone_a' => 'Phone A',
            'phone_b' => 'Phone B',
            'begin_date' => 'Begin Date',
            'connection_date' => 'Connection Date',
            'finish_date' => 'Finish Date',
            'direction' => 'Direction',
            'comment' => 'Comment',
        ];
    }
}
