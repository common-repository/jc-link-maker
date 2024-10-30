<?php
class LinkMaker_Admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
    }
    
    public function menu()
    {
        add_menu_page('Link Maker', 'Link Maker', 'administrator', plugin_basename(LinkMaker::FILE), array($this, 'links'));
        add_submenu_page(
           plugin_basename(LinkMaker::FILE),
           'Add Links',
           'Add Links',
           'administrator',
           plugin_basename(LinkMaker::FILE.'-addLinks'),
           array($this, 'addLinks')
       );  
        
        
    }
    
    public function links()
    {
      if($_GET['action'] == 'addLinks'){
        $this->addLinks();die;
      }
      if($_GET['action'] == 'edit'){
        $this->editLinks();die;
      }
      if($_GET['action'] == 'delete'){
        $this->deleteLinks();die;
      }

        $queryArgs = array(
            'page' => plugin_basename(LinkMaker::FILE),
        );
        $data = array(
            'queryArgs' => $queryArgs,
            'results' =>get_option(LinkMaker::OPTION_KEY.'_links', array()),
            'baseUrl' => admin_url('/admin.php')
        );
        echo LinkMaker_View::render('admin_links', $data); 
    }

    public function editLinks()
    {
        if($_POST['edit'] =='Update' && isset($_POST['id'])){
            $options = get_option(LinkMaker::OPTION_KEY.'_links', array());
            $array = array(
                'link'   => $_POST['link'],
                'target'   => $_POST['target'],
                'class'   => $_POST['class'],
                'linkword'   => $_POST['linkword'],
                'casesensitive'   => $_POST['casesensitive']
                
            );
            $options[$_POST['id']] = $array;

            update_option(LinkMaker::OPTION_KEY.'_links', $options);
            $this->updateFlash('Link has been updated successfully');    
            $this->redirectUrl(get_bloginfo('wpurl').'/wp-admin/admin.php?page=link-maker/link-maker.php');
        }else{
           $data['links'] = get_option(LinkMaker::OPTION_KEY.'_links', array());         
           $data['editLinks'] = $_GET['id'];
            echo LinkMaker_View::render('admin_addLinks', $data); 
        }

    }

    public function deleteLinks()
    {
        if(isset($_GET['id'])){
            $options = get_option(LinkMaker::OPTION_KEY.'_links', array());
            unset($options[$_GET['id']]); 
            update_option(LinkMaker::OPTION_KEY.'_links', $options);
            $this->updateFlash('Link has been deleted successfully');    
            $this->redirectUrl(get_bloginfo('wpurl').'/wp-admin/admin.php?page=link-maker/link-maker.php');
        }
    }

    public function addLinks()
    {
        if($_POST['submit'] == 'Add' && isset($_POST['cl_links_nonce']) && wp_verify_nonce($_POST['cl_links_nonce'], 'cl_links')){
            $options = get_option(LinkMaker::OPTION_KEY.'_links', array());

            $array = array(
                'link'   => $_POST['link'],
                'target'   => $_POST['target'],
                'class'   => $_POST['class'],
                'linkword'   => $_POST['linkword']
                
            );
            $options[] = $array;
            update_option(LinkMaker::OPTION_KEY.'_links', $options);
            $this->updateFlash('Link has been added');
            $this->redirectUrl(get_bloginfo('wpurl').'/wp-admin/admin.php?page=link-maker/link-maker.php');
        }else{
            echo LinkMaker_View::render('admin_addLinks'); 
        }
        
    }
    
    public function menuoption()
    {
        if (isset($_POST['edit']) && isset($_POST['cl_menuoption_nonce']) && wp_verify_nonce($_POST['cl_menuoption_nonce'], 'cl_menuoption')) {
            $this->updateMenuoption();
        }
        $edit = false;
        if ($action == 'edit') {
            $edit = $_GET['id'];
        }
        
        $queryArgs = array('page' => plugin_basename(LinkMaker::FILE) . '-_menuoption', 'id' => '');
        
        $data = array('queryArgs' => $queryArgs, 'baseUrl' => admin_url('/admin.php'), 'editMenuoption' => $edit, 'menuoption' => get_option(LinkMaker::OPTION_KEY . '_menuoption', array()));
        echo LinkMaker_View::render('admin_menuoption', $data);
    }
    
    private function updateFlash($message)
    {
        if($message){
            printf("<div class='updated'><p><strong>%s</strong></p></div>", $message);    
        }else{
            printf("<div class='updated'><p><strong>%s</strong></p></div>", 'Plugin settings updated.');    
        }
    }
    
    private function addMessage($msg, $type = 'success')
    {
        if ($type == 'success') {
            printf("<div class='updated'><p><strong>%s</strong></p></div>", $msg);
        } else {
            printf("<div class='error'><p><strong>%s</strong></p></div>", $msg);
        }
    }
    
    private function redirectUrl($url)
    {
        echo '<script>';
        echo 'window.location.href="' . $url . '"';
        echo '</script>';
    }
}
