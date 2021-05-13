<?php
namespace BandSite;

class StoreViewModel extends BaseViewModel
{
    public function __construct(){
        parent::__construct();
        $this->handleSubmit();
        $this->authenticate();
    }

    private function handleSubmit(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return;
        }

        try {
           

        } catch (\Exception $e) {
            $this->log->error($e->getMessage());
        }
    }
}
