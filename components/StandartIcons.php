<?php
/**
 * Created by PhpStorm.
 * User: Tusya
 * Date: 25.05.2018
 * Time: 21:14
 */

namespace app\components;



use yii\base\Component;

Class StandartIcons extends Component
{
    const ICONS = [
        'OK' => 'ok',
        'ARROW_DOWN' => 'arrow_down',
        'ARROW_RIGHT' => 'arrow_right',
        'BLACK_EYE' => 'black_eye',
        'BLACK_HEART' => 'black_heart',
        'BLACK_MESSAGE' => 'black_message',
        'ORANGE_ARROW_RIGHT' => 'orange_arrow_right',
        'RED_CROSS' => 'red_cross',
        'STACK_HIGHLIGHT' => 'stack_highlight',
        'STACK' => 'stack',
        'WARNING' => 'warning',
        'WHITE_EYE' => 'white_eye',
        'WHITE_HEART' => 'white_heart',
        'WHITE_MESSAGE' => 'white_message',
        'WHITE_SEARCH' => 'white_search',
    ];

    const EXTENSION = '.png';

    const PATH_TO_ICONS = DIRECTORY_SEPARATOR . 'assets' .
    DIRECTORY_SEPARATOR . 'pictures' .
    DIRECTORY_SEPARATOR . 'interface' .
    DIRECTORY_SEPARATOR . 'icons';
    /**
     * @param $name
     * @return string
     */
    public static function getLinkIcon($name)
    {
        $path = static::PATH_TO_ICONS . DIRECTORY_SEPARATOR . $name . static::EXTENSION;
        return $path;
    }
}