<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

     date_default_timezone_set('America/New_York');

    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use($app){
        return $app['twig']->render('index.html.twig');
    });

//  end of required  // TODO: go back over the lesson in order to complete the remaining placeholder functions below.

//  SAVE STORE  // & //  SAVE BRAND  //
    $app->post("/stores", function() use($app) {

        $name = $_POST['store_name'];
        $new_store = new Store($name);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/brands", function() use($app){
        $name = $_POST['brand_name'];
        $new_brand = new Brand($name);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

// OTHER STORE FUNCTIONS //
    $app->get("/stores", function() use($app){
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/store/{store_id}", function($store_id) use($app){
        $current_store = Store::find($store_id);
        return $app['twig']->render('store.html.twig', array(
          'store'=>Store::find($store_id),
          'brands'=>Brand::getAll(),
          'store_brands'=>$current_store->getBrands()
        ));
    });

    $app->get("/store/{store_id}/edit", function($store_id) use($app){
        $store = Store::find($store_id);
        return $app['twig']->render('store_edit.html.twig', array('store'=>$store));
    });

    $app->post("/stores/{store_id}", function($store_id) use($app){
        $store = Store::find($store_id);
        $store->update($_POST['new_store_name']);
        return $app['twig']->render('store.html.twig', array('store'=>$store, 'brands'=>Brand::getAll(), 'store_brands'=> Store::find($store_id)->getBrands()));
    });

// OTHER BRAND FUNCTIONS //
    $app->post("/brands", function() use($app){
        $name = $_POST['brand_name'];
        $new_brand = new Brand($name);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

?>
