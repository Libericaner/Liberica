<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 10:23
 *
 * Each method need the prefix X (for Xecurity). Without it can't be called from a form
 */


function XtoHome() {
    
    header('Location: ./?view=home');
    exit;
}

function Xlogin() {
    
    if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if (User::verifyUser($_POST['username'], $_POST['password'])) {
            $_SESSION[USER] = $_POST['username'];
            $_SESSION[TOKEN] = bin2hex(random_bytes(32));
            $_SESSION['t2'] = bin2hex(openssl_random_pseudo_bytes(32));
            header("Location: ./?view=hidden");
            exit;
        }
        return 'Falsche Anmeldedaten';
    }
    else {
        return 'Gibb überall etwas ein';
    }
}

function Xregister() {
    if (isset($_POST['user'], $_POST['password']) && !empty($_POST['user']) && !empty($_POST['password']))
    {
        if(filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)) {
            if(preg_match('/[a-zA-Z0-9]{8,}/', $_POST['password'])) {
                if(preg_match('/[0-9]/', $_POST['password']) == 1) {
                    if(preg_match('/[$\_\.\-\+]/', $_POST['password'])) {
                        if(preg_match('/[a-zA-Z]/', $_POST['password'])) {
                            if (User::addUser($_POST['user'], $_POST['password'])) {
                                if (User::verifyUser($_POST['user'], $_POST['password'])) {
                                    $_SESSION['u'] = $_POST['user'];
                                    header("Location: ./?view=hidden");
                                    exit;
                                }
                                return 'Es ist ein Fehler aufgetreten';
                            }
                            return 'Benutzer existierts bereits';
                        }
                        return 'Mindestens ein Gross-/Kleinbuchstabe';
                    }
                    return 'Mindestens 1 Sonderzeichen';
                }
                return 'Mindestens 1 Zahl';
            }
            return 'Mindestens 8 Zeichen';
        }
        return 'Die E-Mail ist ungültig';
    }
    return 'Fülle alle Felder aus';
}

function XcreateGallery()
{
    if (isset($_POST['name'], $_POST['description']))
    {
        if (empty($_POST['name'])) {
            return 'Gib einen Namen ein';
        }
        
        $u = User::getUserByEmail($_SESSION[USER]);
          
        $g = new Gallery();
        $g->addGallery(intval($u->getIdUser()), $_POST['name'], $_POST['description']);
        header("Location: ");
      }
  }

function XuploadImage(){

    if (isset($_POST['title'], $_POST['tags'], $_POST['galleryid']) && !empty($_POST['title']) && $_FILES['picture']['name'] != "") {
    
        $p = new Picture();
    
        $file_size = $_FILES['picture']['size'];
        $isImage = getimagesize($_FILES["picture"]['tmp_name']);
    
        if ($isImage !== FALSE) {
            if ($file_size < 4000000) {
                $p->addPicture($_POST['galleryid'], $_POST['tags'], $_POST['title']);
                header("Location: ");
            }
            return 'Das Bild ist zu gross';
        
        } else {
            return 'Der Upload ist kein Bild';
        }
    
    }
    return 'Angaben fehlen';
  }
    }
}

function XdeleteGallery()
{
    if (!isset($_POST['pw'], $_POST['gid']))
        return "Bitte gib dein Passwort ein";
    
    if (!User::verifyUser($_SESSION[USER], $_POST['pw']))
        return "Passwort ungültig";
    
    $gallery = Gallery::getGalleryById($_POST['gid']);
    
    if (is_null($gallery))
        return "Ein Fehler ist aufgetreten";
    
    Gallery::deleteGalleryById($gallery->getId());
    
    header("Location: ");
}