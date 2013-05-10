<?php

class template
{

//Data members
var $files=array();
var $variables=array();
var $open_brace='{';
var $close_brace='}';

//member functions
//function to save content of each file
function file_register($fileid,$filename)
{
	//Open file in read mode
	$fo=fopen($filename,"r") or die("Natd open file");
	//Read the content of file
	$content=fread($fo,filesize($filename));
	//Assign the content to a uniique file id
	$this->files[$fileid]=$content;
	//close the file	
	fclose($fo);
}

//function to save all variables used to parse in template
function var_register($fileid,$varnames)
{
	//making an array of variable names in $varnames string
	$vararr=explode(",",$varnames);
	//accessing the content of $vararr
	while(list(,$value)=each($vararr))
	{
		$this->variables[$fileid][]=$value;
	}
}

//parsing function 1
function file_parse($fileid)
{
	//count number of variables
	$var_count=count($this->variables[$fileid]);

 	//making array of file keys
	$file_keys=array_keys($this->files);

	//checking if fileid is in keys of files array
	if(in_array($fileid,$file_keys) && ($var_count>0)):

		//defining varible for indexing array
		$x=0;
		while($x<sizeof($this->variables[$fileid]))
		{
			$string=$this->variables[$fileid][$x];

			//getting the string to replace
			$toreplace=$this->open_brace.$string.$this->close_brace;

			//{title} will be replaced by value of $title variable...therefore double $ placed.
			GLOBAL $$string;
			$this->files[$fileid]=str_replace($toreplace,$$string,$this->files[$fileid]);
			$x++;
		}
	endif;
}

//parsing function 2
function file_parse2($fileid)
{
		$this->file_parse($fileid);
		return $this->files[$fileid];
}

//function to display the whole page
function display_page($fileid)
{
	print $this->files[$fileid];
}
}
//creating object
$template=new template;
?>
