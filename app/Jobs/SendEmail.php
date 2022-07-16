<?php
namespace App\Jobs;

class SendWelcome implements ShouldQueue
{
    /**
     * Số lần job sẽ thử thực hiện lại
     *
     * @var int
     */
    public $tries = 3;
}
