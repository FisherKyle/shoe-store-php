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

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //  end of required  // TODO: go back over the lesson in order to complete the remaining placeholder functions below.

    $app->get("/", function() use($app) {
      return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    // STORE FUNCTIONS //

    $app->get("/create_store", function() use($app) {
        return $app['twig']->render('create_store.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/new_store", function() use($app) {
        $new_store = new Store($_POST['name']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/store/{id}", function($id) use($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll()));
    });

    $app->post("/store/{id}/added_brand", function($id) use($app) {
        $store = Store::find($id);
        $brand_id = intval($_POST['brand_id']);
        $brand = Brand::find($brand_id);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll()));
    });

    $app->delete("/store/{id}/delete", function($id) use($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/store/{id}/edit", function($id) use($app) {
        $store = Store::find($id);
        return $app['twig']->render('edit_store.html.twig', array('store' => $store, 'brands' => Brand::getAll()));
    });

    $app->patch("/store/{id}", function($id) use($app) {
        $store = Store::find($id);
        $store->update($_POST['new_name']);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => Brand::getAll()));
    });

// BRAND FUNCTIONS //

    $app->get("/create_brand", function() use($app) {
        return $app['twig']->render('create_brand.html.twig');
    });

    $app->post("/new_brand", function() use($app) {
        $new_brand = new Brand($_POST['name']);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brand/{id}", function($id) use($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => Store::getAll()));
    });

    $app->post("/brand/{id}/added_store", function($id) use($app) {
        $brand = Brand::find($id);
        $store_id = $_POST['store_id'];
        $store = Store::find($store_id);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => Store::getAll()));
    });

    return $app;

  ?>
