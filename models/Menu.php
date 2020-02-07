<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $status
 * @property string $descriprion
 * @property string $updated_at
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['status'], 'integer'],
            [['descriprion'], 'string'],
            [['updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'status' => 'Status',
            'descriprion' => 'Descriprion',
            'updated_at' => 'Updated At',
        ];
    }
	
	private static function getMenuItemsTop($nameMenu)
    {
        $items = [];
        
        $code = $nameMenu;
        
        $query_menu = Menu::find()
                        ->andWhere(['code' => $code, 'status' => 1])
                        ->one();
        
        $query = categories::find()
                    ->andWhere([
                        'menu_id' => $query_menu->id,
                        'status' => 1
                     ])
                    ->all();
        
        foreach ($query as $item)
        {
            if ( empty($items[$item->parent_id]) )
            {
                $items[$items->parent_id] = [];
            }
            
            $items[$item->parent_id][] = $item->attributes;
        }
        
        return $items;
    }
    
    /*
     * @inheritdoc
     */
    public static function viewMenuItemsTop($nameMenu, $parentId = 0)
    {        
        $array = self::getMenuItemsTop($nameMenu);
        
        if ( empty($array[$parentId]) ) { return; }
        
        for ( $i = 0; $i < count($array[$parentId]); $i++ )
        {
            $result[] = [
                'label' => $array[$parentId][$i]['name'],
                'url' => [$array[$parentId][$i]['url_item'].'/index'],
                'items' => self::viewMenuItemsTop($array[$parentId][$i]['id'], $nameMenu)
            ];
        }
        
        return $result;
    }
}
