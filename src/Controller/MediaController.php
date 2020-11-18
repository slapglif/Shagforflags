<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\Upload\UgUpload;
use App\Services\Upload\SimpleImage;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/media")
 * @author Ali Gencer <a.e.gencer@hotmail.de>
 */
class MediaController extends AbstractController
{
    public function __construct() {
        if (!strstr($_SERVER['HTTP_HOST'], 'shagforflags')) {
            exit();
        }
    }

    /**
     * @Route("/upload-photo", name="media_upload_photo")
     */
    public function uploadPhotoAction(Security $security, ContainerInterface $container){
        if ($security->isGranted('ROLE_USER')) {
            if ($_FILES["file"]) {
                $upload = UgUpload::factory("build/files/upload/user");
                $upload->file($_FILES["file"]);
                $upload->set_max_file_size(5);
                $upload->set_allowed_mime_types(
                    array(
                        'image/jpeg',
                        'image/png',
                    )
                );

                $img_name_array = explode(".", $_FILES["file"]['name']);
                $img_ext = strtolower($img_name_array[1]);

                $user_helper = $container->get("user");
                $user_email = $user_helper->getActiveUser()->getEmail();
                $img_name = $user_helper->createFileHash($user_email, $img_ext);

                $upload->set_filename($img_name);
                $save = $upload->upload();

                if(!empty($save["errors"])) {
                    exit("upload error");
                }

                // Rotate image if needed
                $img_full_path = "build/files/upload/user/" . $img_name;
                $exif = exif_read_data($img_full_path);
                if (isset($exif['Orientation'])) {
                    $orientation = $exif['Orientation'];

                    switch($orientation) {
                        case 3:
                            $source = @imagecreatefromjpeg($img_full_path);
                            if ($source) {
                                $rotate = imagerotate($source, 180, 0);
                                imagejpeg($rotate, $img_full_path, 100);

                                imagedestroy($source);
                                imagedestroy($rotate);
                            }
                            break;

                        case 6:
                            $source = @imagecreatefromjpeg($img_full_path);
                            if ($source) {
                                $rotate = imagerotate($source, -90, 0);
                                imagejpeg($rotate, $img_full_path, 100);

                                imagedestroy($source);
                                imagedestroy($rotate);
                            }
                            break;

                        case 8:
                            $source = @imagecreatefromjpeg($img_full_path);
                            if($source) {
                                $rotate = imagerotate($source, 90, 0);
                                imagejpeg($rotate, $img_full_path, 100);

                                imagedestroy($source);
                                imagedestroy($rotate);
                            }
                            break;
                    }
                }

                exit($img_name);
            }
            exit();
        }
        exit();
    }

    /**
     * @Route("/crop-photo", name="media_crop_photo")
     */
    public function cropAction(Security $security, ContainerInterface $container, Request $request){
        if ($security->isGranted('ROLE_USER')) {
            $file_name = ltrim($request->get('file_name'),"/");
            $x = $request->get('x');
            $y = $request->get('y');
            $ratio = $request->get('ratio') ? $request->get('ratio') : 1;
            $upload_type = $request->get('upload_type');
            $thumbs = $request->get('thumbs');
            $status = $request->get('status') ? $request->get('status') : 'active';
            $size = $request->get('size');

            // Crop image
            $img = new SimpleImage($file_name);

            // if there is no size defined, take the full image width
            if(empty($size)){
                $width = $img->get_width();
                $height = $img->get_height();
            }else{
                $height = $y + $size / $ratio;
                $width = $x + $size / $ratio;
            }


            $img->crop(
                $x,
                $y,
                $width,
                $height
            );

            $img->save($file_name);

            // Create Thumbnail
            if(!empty($thumbs)) {

                if(!is_array($thumbs)){
                    $thumbs = explode(",", $thumbs);
                }

                $user_helper = $container->get("user");
                foreach ($thumbs as $thumb) {
                    $thumb_path = $user_helper->getThumbPath($file_name, $thumb);
                    $thumb_dir_path = $user_helper->getThumbPath($file_name, $thumb, false);

                    if(!is_dir($thumb_dir_path)){
                        mkdir($thumb_dir_path);
                    }

                    $resize = new SimpleImage($file_name);
                    $resize->thumbnail($thumb,$thumb / $ratio);
                    $resize->save($thumb_path);
                }
            }

            $user_id = $user_helper->getActiveUser()->getId();
            $file_name_only = substr($file_name, strrpos($file_name, '/') + 1);
            $user_helper->updateProfilePhoto($user_id, $file_name_only);

            exit();
        }
        exit();
    }

    /**
     * @Route("/unlink", name="media_unlink")
     */
    public function unlinkAction(Security $security, ContainerInterface $container, Request $request){
        if ($security->isGranted('ROLE_USER')) {
            $user_helper = $container->get("user");
            $data = $request->request->all();

            // get original path
            $path = ltrim($data['file_name'], "/");

            // clear thumb path if it is a thumb photo
            $originalPath = preg_replace('/\/thumb-\d*/', '', $path);

            // remove file extension
            //$fileNameWithOutExtension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $originalPath);

            // get file name
            $fileName = $user_helper->returnExplode($originalPath, "/", "l");

            // remove DB entry if USER has an entry
            $removed = $user_helper->removeProfilePhoto($user_helper->getActiveUser()->getId(), $fileName);

            if ($removed) {
                // get thumbs path
                $thumbsPath = str_replace($fileName, "", $originalPath);

                // unlink original image
                @unlink($originalPath);

                // unlink thumbs
                @array_map('unlink', glob($thumbsPath . "*/" . $fileName));
            }

            exit("1");
        }

        exit("1");
    }

    /**
     * @Route("/upload-story-photo", name="media_upload_story_photo")
     */
    public function uploadStoryPhotoAction(Security $security, ContainerInterface $container, Request $request){
        if ($security->isGranted('ROLE_USER')) {
            if ($_FILES["file"]) {
                $upload = UgUpload::factory("build/files/upload/prestory");
                $upload->file($_FILES["file"]);
                $upload->set_max_file_size(5);
                $upload->set_allowed_mime_types(
                    array(
                        'image/jpeg',
                        'image/png',
                    )
                );

                $img_name_array = explode(".", $_FILES["file"]['name']);
                $img_ext = strtolower($img_name_array[1]);

                $user_helper = $container->get("user");
                $user_email = $user_helper->getActiveUser()->getEmail();
                $random_number = rand();
                $img_name = $user_helper->createFileHash($user_email, $img_ext, $random_number);

                $upload->set_filename($img_name);
                $save = $upload->upload();

                if(!empty($save["errors"])) {
                    exit("upload error");
                }

                exit($img_name);
            }
            exit();
        }
        exit();
    }

    /**
     * @Route("/unlink-story", name="media_unlink_story")
     */
    public function unlinkStoryAction(Security $security, ContainerInterface $container, Request $request){
        if ($security->isGranted('ROLE_USER')) {
            $data = $request->request->all();

            if ($data['file_name']) {
                $path_with_file = "build/files/upload/prestory/".$data['file_name'];

                // unlink original image
                @unlink($path_with_file);
            }
            exit("1");
        }
        exit("1");
    }
}