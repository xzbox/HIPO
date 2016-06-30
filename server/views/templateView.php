<?php
/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/
namespace views;
use lib\view\view as View;

/**
 * Class templateView
 * @package views
 */
abstract class templateView extends View{
    /**
     * @param $class
     *
     * @return mixed|string
     */
    public static function getTemplate($class){
        //TODO fix this bug
        $name   = explode('\\',$class);
        $templateFile = 'templates/'.$name[1].".html";
        if(file_exists($templateFile)){
            return self::parseTemplate(file_get_contents($templateFile));
        }
        return ":(";
    }

    /**
     * @param $template
     *
     * @return mixed
     */
    protected static function parseTemplate($template){
        return $template;
    }
}