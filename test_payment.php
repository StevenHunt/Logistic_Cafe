<?php

namespace TestPayment;



class Payment

{

    /**

     * @param string $number

     * @param string $cvc

     * @param null $amount

     * @return bool

     */

    public function charge($number = '', $cvc = '', $amount = null)

    {

        if (substr($number, 0, 4) == '4444') {

            return false;

        }



        return true;

    }

}
