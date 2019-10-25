<?php
/**
 * Created by PhpStorm.
 * User: it6
 * Date: 10/20/2019
 * Time: 11:21 AM
 */

namespace App;


class Item
{
    private $name;
    private $qty;
    private $price;
    private $rp;

    public function __construct($name='',$qty='',$price='',$rp=false)
    {
        $this->name=$name;
        $this->qty=$qty;
        $this->price=$price;
        $this->rp=$rp;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        $rightCols=10;
        $leftCols=14;
        $midCol=10;
        if ($this->rp){
            $leftCols=$leftCols /2 - $rightCols / 2;
        }
        $left=str_pad($this->name,$leftCols);
        $sign=($this->rp ? 'Rp ':'');
        $mid=str_pad($this->qty,$midCol);
        $right=str_pad($sign.$this->price,$rightCols,' ',STR_PAD_LEFT);
        return "$left$mid$right\n";
    }

}