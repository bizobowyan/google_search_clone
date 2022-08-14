<?php 

class DomDocumentParser{
	private $doc;
	public function __construct($url){
		$options =  array(
			'http' => array(
				'method' => "GET",
				'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36\n" 
			)
		);

		$context = stream_context_create($options);

		$this->doc= new DomDocument();

		$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getLinks(){
		return $this->doc->getElementsByTagName("a");
	}
	public function getTitleTags(){
		return $this->doc->getElementsByTagName("title");
	}

	public function getMetaTags(){
		return $this->doc->getElementsByTagName("meta");
	}

	public function getImages(){
		return $this->doc->getElementsByTagName("img");
	}
}

?>





