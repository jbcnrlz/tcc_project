<?php
namespace app\models;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\imagine\Image;

ini_set('memory_limit', '-1');

class CropImagem extends ActiveRecord{
    
   
    public $foto;
    public $crop_info;
    public $alias;
    public $nomeFoto;
    
    
    public static function tableName() {
        return 'usuario';
    }
    
    public function rules() {
        return [
                ['foto', 'required','message'=>'Caso deseja alterar, clique em abrir e selecione a imagem'],
                ['foto', 'image', 'extensions' => ['jpg', 'jpeg'], 'mimeTypes' => ['image/jpeg', 'image/pjpeg']],
                ['crop_info', 'safe'],
           ];
    }
    
    public function afterSave($insert, $changedAttributes) {

        // open image
                   
            $image = Image::getImagine()->open($this->foto->tempName);
//            $imageOriginal = Image::getImagine()->open($this->foto->tempName);

      
      
        // rendering information about crop of ONE option 
        $this->nomeFoto = $this->id.'ft'.md5(time().rand());
            
         if (!empty(Json::decode($this->crop_info)[0])) {
        $cropInfo = Json::decode($this->crop_info)[0];
        $cropInfo['dWidth'] = (int) $cropInfo['dWidth']; //new width image
        $cropInfo['dHeight'] = (int) $cropInfo['dHeight']; //new height image
        $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
        $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y
        // Properties bolow we don't use in this example
        //$cropInfo['ratio'] = $cropInfo['ratio'] == 0 ? 1.0 : (float)$cropInfo['ratio']; //ratio image. 
        //$cropInfo['width'] = (int)$cropInfo['width']; //width of cropped image
        //$cropInfo['height'] = (int)$cropInfo['height']; //height of cropped image
        //$cropInfo['sWidth'] = (int)$cropInfo['sWidth']; //width of source image
        //$cropInfo['sHeight'] = (int)$cropInfo['sHeight']; //height of source image
        //delete old images
//        $node
//        $oldImages = FileHelper::findFiles(Yii::getAlias('@webroot/upload/avatar/'), [
//                    'only' => [
//                        $this->id . '.*',
//                        'thumb_' . $this->id . '.*',
//                    ],
//        ]);
//        for ($i = 0; $i != count($oldImages); $i++) {
//            @unlink($oldImages[$i]);
//        }

        //saving thumbnail
        $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
        $cropSizeThumb = new Box(200, 200); //frame size of crop
        $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
        $pathThumbImage = Yii::getAlias('@app/upload/avatarPerfil/')
                . '/'.$this->nomeFoto
                . '.'
                . strtolower($this->foto->getExtension());
         //saving original
//        $image->thumbnail($image->getSize()->widen(800))->save(Yii::getAlias('@webroot/upload/avatar/')
//                . '/'
//                . $this->id
//                . '.'
//                . $this->foto->getExtension(), ['quality' => 100]);
        
        $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);

       
        
//        $this->foto->saveAs(
//                Yii::getAlias('@webroot/upload/avatar/')
//                . '/'
//                . $this->id
//                . '.'
//                . $this->foto->getExtension()
//        );
        }
    }
   
}

