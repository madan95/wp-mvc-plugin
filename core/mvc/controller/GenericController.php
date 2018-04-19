<?php
class GenericController implements ControllerInterface{
  protected $service;
  protected $entity_manager;


  public function __construct(){
    $this->entity_manager = EntityManagerFactory::createEM();
  }

//By default if no ajax_aciton is index() which shows list of table items
  public function index($request){
    /*$twig_loader = new Twig_Loader_Filesystem(BASEPATH . '/Implement/mvc/view/models/' . $request['table_name']);
    $twig = new Twig_Environment($twig_loader);
*/
    require (BASEPATH . '/Implement/mvc/view/models/'.$request['table_name'].'/index.php');

  /*  echo $twig->render('index.html.twig', array(
      'content' => $content
    ));*/
  }

  public function getGridData($request){
    return $this->service->getGridData($request);
  }



//Get the Data required by bootgrid to display list of the table contents
/*  public function getGridData($request){
    if(!empty($request['id']) || !empty($request['node_id']) || !empty($request['parent_id'])){
      //Send Specific row/column of table
      return $this->service->getGridData($request);
    }else{
      //Send all the default row/column of table
      return $this->service->getGridDataAll($request);
    }
  }
*/

//Get Data using Bootgrid options
  public function getBootGridData($request){
    return $this->service->getBootGridData($request);
  }

  // View specific Item Details
    public function viewDetail($request){
      return require (BASEPATH. '/Implement/mvc/view/models/'.$request['table_name'].'/viewDetail.php');
    }

    public function viewCurrent($request){
      $current_user = wp_get_current_user();
      $current_user_id = $current_user->ID;
      return require (BASEPATH. '/Implement/mvc/view/models/'.$request['table_name'].'/viewDetailCurrent.php');
    }

    //Used to create new row on a table
    public function createNew($request){
     $this->service->createOrUseExisting($request);
    }
    //Use exisiting model
    public function useExisting($request){
      $this->service->createOrUseExisting($request);
    }


  public function delete($request){
    $this->service->delete($request);
  }

  public function remove($request){
    $this->service->remove($request);
  }

  public function select2($request){
    $data = $this->service->select2($request);
  //  $data[]=  array('id' => '0', 'text' =>'product');
    echo json_encode($data);
  }

  public function setService($service){
    $this->service = $service;
  }

  public function edit($request){
    return require (BASEPATH . '/Implement/mvc/view/models/'.$request['table_name'].'/edit.php');
  }

  public function update($request){
    $this->service->update($request);
  }

  public function view($request){
    $data = $this->service->view($request);
    if($request['id']){
      print_r($data);
    }else{
      print_r($data);
    }
  }



//create a register view for the item
  public function register($request){
    return require (BASEPATH . '/Implement/mvc/view/models/'.$request['table_name'].'/register.php');
  }









}
 ?>
