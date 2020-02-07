<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property int $menu_id
 * @property int $parent_id
 * @property string $url
 * @property string $updated_at
 *
 * @property Menu $parent
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status', 'menu_id', 'parent_id'], 'integer'],
            [['updated_at'], 'safe'],
            [['title', 'url'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'menu_id' => 'Menu ID',
            'parent_id' => 'Parent ID',
            'url' => 'Url',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }
	
	private static function getMenuItems()
    {
        $items = [];
        
        $code = 'top-menu';
        
        $query_menu = Menu::find()
                        ->andWhere(['code' => $code, 'status' => 1])
                        //->andWhere([])
                        ->one();
        
        $query = self::find()
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
    public static function viewMenuItems($menuId = 0)
    {        
        $array = self::getMenuItems();
        
        if ( empty($array[$menuId]) ) { return; }
        
        for ( $i = 0; $i < count($array[$menuId]); $i++ )
        {
            $result[] = [
                'label' => $array[$menuId][$i]['title'],
                'url' => $array[$menuId][$i]['url'],
                'items' => self::viewMenuItems($array[$menuId][$i]['id'])
            ];
        }
        
        return $result;
    } 
}
