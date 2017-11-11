<?php
/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:47
 *
 * This is the only file the user calls. It instantiates a Controller
 */

const MVC = 'mvc/';

require_once MVC . 'config.php';
require_once MVC . 'settings.php';

// IMPORTANT: APPLICATION SPECIFIC

const MODEL_CONTROLLER = MVC . 'model/ModelController';
const MODEL_DTO = MVC . 'model/DataObjects';
const MODEL_QUERIES = MVC . 'model/Queries';

require_once MODEL_DTO . 'Gallery.php';
require_once MODEL_DTO . 'Tag.php';
require_once MODEL_DTO . 'Picture.php';
require_once MODEL_DTO . 'User.php';

require_once MODEL_QUERIES . 'GalleryQueries.php';
require_once MODEL_QUERIES . 'PictureQueries.php';
require_once MODEL_QUERIES . 'TagQueries.php';
require_once MODEL_QUERIES . 'UserQueries.php';

require_once MODEL_CONTROLLER . 'Controller.php';
require_once MODEL_CONTROLLER . 'GalleryController.php';
require_once MODEL_CONTROLLER . 'PictureController.php';
require_once MODEL_CONTROLLER . 'TagController.php';
require_once MODEL_CONTROLLER . 'UserController.php';

const CONTROLLER = MVC . 'Controller/';

require_once CONTROLLER . 'Controller.php';
require_once CONTROLLER . 'View.php';

require_once CONTROLLER . 'commands.php';
require_once CONTROLLER . 'orders.php';

require_once CONTROLLER . 'library.php';
require_once CONTROLLER . 'printLib.php';

const DATABASE = MVC . 'database/';

require_once DATABASE . 'Database.php';
require_once DATABASE . 'DBConnection.php';
require_once DATABASE . 'Executor.php';
require_once DATABASE . 'DataObjectMapper.php';

new Controller();