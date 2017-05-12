<?php
/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:47
 *
 * This is the only file the user calls. It instantiates a Controller
 */


new Controller();


const MVC = 'mvc/';

require_once MVC . 'config.php';
require_once MVC . 'settings.php';


const CONTROLLER = MVC . 'Controller/';

require_once CONTROLLER . 'Controller.php';
require_once CONTROLLER . 'View.php';

require_once CONTROLLER . 'commands.php';
require_once CONTROLLER . 'orders.php';

require_once CONTROLLER . 'library.php';
require_once CONTROLLER . 'printLib.php';


const DATABASE = MVC . 'Database/';

require_once DATABASE . 'Database.php';
require_once DATABASE . 'DBConnection.php';

require_once 'mvc/Database/DBConnection.php';


// IMPORTANT: APPLICATION SPECIFIC

const MODEL = MVC . 'Model/';

require_once MODEL . 'Gallery.php';
require_once MODEL . 'Model.php';
require_once MODEL . 'Picture.php';
require_once MODEL . 'Tag.php';
require_once MODEL . 'User.php';