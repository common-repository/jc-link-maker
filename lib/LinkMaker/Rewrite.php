<?php

class LinkMaker_Rewrite
{
    public function __construct()
    {
        add_action('parse_request',array(&$this, 'replace_content'));
    }
   
   public function replace_content(&$wp) {
       add_filter('the_content', array(&$this,'filter_content'));
   }

   public function filter_content($content){
   		$links = get_option(LinkMaker::OPTION_KEY.'_links', array());
   		foreach($links as $link){
   			if($link['casesensitive'] == 'yes'){
   				$content = preg_replace('/\b'.$link['linkword'].'\b/', '<a href="'.$link['link'].'" target="'.$link['target'].'" class="'.$link['class'].'">'.$link['linkword'].'</a>', $content);
   			}else{
   				$content = preg_replace('/\b'.$link['linkword'].'\b/i', '<a href="'.$link['link'].'" target="'.$link['target'].'" class="'.$link['class'].'">'.$link['linkword'].'</a>', $content);	
   			}
   			
   		}
   		return $content;
   }

}