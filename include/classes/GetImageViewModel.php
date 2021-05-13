<?php 

namespace BandSite;

class GetImageViewModel extends BaseViewModel 
{
    public function __construct(){
        parent::__construct();
        $this->getImage();
    }

    private function getImage(): void {
        $imageId = $_SESSION['imageId'] ?? null;

        if (!$imageId) {
            return;
        }

        try {
            $result = $this->pdo->query("SELECT * FROM image WHERE id = $imageId");

            if ($result->rowCount() !== 1) {
                throw new \Exception('Problem fetching image with id: '+$imageId);
            }

            $image = $result->fetchObject();

            header("Content-Type: ". $image->mimetype);
            echo $image->imagedata;
        } catch(\Exception $e) {
            $this->log->error($e->getMessage());
        }
    }
}