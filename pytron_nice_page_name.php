<?php  
/* the page is the same name as the .py page */
	

// Description: Directories that use the internal routing of a web browser and allow to include from 
//              anywhere within a domain name without having the exact path to the include file

// EDIT THIS, this 
$project_root = 'test2/';			// when '' then it's document root (of domain name)  MUST put a trailing forward slash at the end of project root (should) 
							// use either '' (that is empty string) or some_directory/   (not forward slash by itself, i.e.,  '/' )
							//
							// set to project root, e.g., project_root = 'test2/';
							
$auto_print_wwwlog_literal = True;


// Created By Stan "Lee" Switaj

// How it works:  Run this php program from ANY subdirectory on a webserver.

// how it works:  As an example your project is in a folder named  fiction_books  on a root of a domain name
//                Then        'fiction_books'      is the      project_root
//
//                And your project contains a folder that you place your includes for css, js, etc.
//                Therefore, an example is:                  'include_directory/file_to_include_to_your_project.php'


$done = false;

$quick_development_mode = false   ; // puts all the files in the same folder
									// i.e., this_page.php, this_page.py, this_page.css this_page.js (though the compiled folder will have the actual source that's sent to the browser)
									//                      EDIT_THIS_FILE (the .py .css, .js, .pyj  the web site files), do NOT edit the .php file, except for its options



# libs, e.g., jquery that are included frequently in a project (a way to dynamic relative directories (term i coined) to domain name, (and even an offset directory)
$css_folder_always   = 'css'       ; // when '' therefore not using, or optionally set to the same folder as css_folder
$js_rs_folder_always = 'js'        ; // when '' therefore not using, or optionally set to the same folder as js_rs_folder

$css_per_page_folder_using   = true; // when false, perhaps use a file using   note: just the folder is created
$js_rs_per_page_folder_using = true; // javascript rapydscript                 ...

$css_per_page_file_using = true;     // when  css_per_page_folder_using    is set to true, then this should be false
$js_per_page_file_using  = true;     // when  js_rs_per_page_folder_using  is set to true, then this should be false
$rs_per_page_file_using  = true;     // when  js_rs_per_page_folder_using  is set to true, then this should be false

// when the three previous choices are false, then just a file in the following directories by the same name as the file
$include_folder = 'pyinclude/'  ;
$css_folder     = 'pycss/'      ;
$js_rs_folder   = 'pyjs_rs/'    ;
// folders will be same name as filename within /pycss  or /pyjs_rs
// simply include any css or js within those folders
//  
   
$compiled_folder = 'COMPILED/'          ;	// MUST INCLUDE TRAILING backslash or forwardslash
											// use either '' (that is empty string) or some_directory/   (not forward slash by itself, i.e.,  '/' )
											// when this is '' (its the same as the folder SERVER[DOCUMENT_ROOT] is)
										
   								
$preprocessor_folder = 'PREPROCESSOR/'	;   // MUST INCLUDE TRAILING backslash or forwardslash
											// in most cases this will be '' (emtpy string), this just means that
											// the simple_pre_processor.py and literal.py  are placed in 
											// the same folder as defined by    project root
											// The preprocessor FILES contained within this folder
			
			
$document_root = gets_document_root_with_trailing_fs();

function icheck_run_all($s){
	$s=icheck_run1($s);
	$s=icheck_run2($s);
	$s=icheck_run3($s);
	return $s;
}									
function icheck_run1($s){return b2f($s); }
function icheck_run2($s){return (substr($s, -1) == '/') ? $s : $s . '/'; }
function icheck_run3($s){return ($s=='.' || $s=='./' || $s=='.\\' || $s=='/' || $s=='\\') ? '' : $s; } // current working directory should be  '' (recommended, therefore this line not needed)  (perhaps needed if you insist on ./  or . as cwd)

print '<h1>Before sanitizing check</h1>';
$arr[]=$document_root;	//note:  array_push($arr, 'hello world'); different syntax in next lines, its same to add to arrays , initialize first either with $arr=[] or $arr=array();
$arr[]=$project_root;
$arr[]=$compiled_folder;
$arr[]=$preprocessor_folder;
$arr[]=$css_folder;
$arr[]=$js_rs_folder;

integrity_check_count($arr);
$array = array(
	'document_root' => $document_root, 
	'project_root' => $project_root, 
	'compiled_folder' => $compiled_folder,
	'preprocessor_folder' => $preprocessor_folder,
	'css_folder' => $css_folder,
	'js_rs_folder' => $js_rs_folder
);
foreach ($array as $key => $value) { echo "$key = $value\n"; }
//foreach($arr as $item){ print 'var='.$item.'<br>'; }

// Sanitizes
$document_root           = icheck_run_all( gets_document_root_with_trailing_fs() );
$project_root            = icheck_run_all( $project_root );
$compiled_folder         = icheck_run_all( $compiled_folder );
$preprocessor_folder     = icheck_run_all( $preprocessor_folder );
$css_folder              = icheck_run_all( $css_folder );
$js_rs_folder            = icheck_run_all( $js_rs_folder );
// next two lines are calculated directories, depend on sanitized variables
$flex_folders            = icheck_run_all( all_folders_after_project_root_until_index($project_root) );
$sources_magic_directory = icheck_run_all( abs_project_root($project_root) . $compiled_folder . $flex_folders );


print '<h1>After sanitizing</h1>';
$arr2[]=$document_root;
$arr2[]=$project_root;
$arr2[]=$compiled_folder;
$arr2[]=$preprocessor_folder;
$arr2[]=$flex_folders;
$arr2[]=$sources_magic_directory;
$arr2[]=$css_folder;
$arr2[]=$js_rs_folder;
$arr2[]=$flex_folders;
$arr2[]=$sources_magic_directory;
integrity_check_count($arr2);

$array2 = array(
	'document_root' => $document_root, 
	'project_root' => $project_root, 
	'compiled_folder' => $compiled_folder,
	'preprocessor_folder' => $preprocessor_folder,
	'flex_folders' => $flex_folders,
	'sources_magic_directory' => $sources_magic_directory,
	
	'css_folder' => $css_folder,
	'js_rs_folder' => $js_rs_folder
);
foreach ($array2 as $key => $value) { echo "$key = $value\n"; }
//foreach($arr2 as $item){ print 'var='.$item.'<br>'; }







// When verified that icheck_run_all are ok, then be sure that the variables corresponding to functions are still called
// Note the following variables must be inititalized by functions (uncomment the next three lines then if required modify code as required,preferred):

//	$document_root            = gets_document_root_with_trailing_fs();
//	$flex_folders             = all_folders_after_project_root_until_index($project_root);
//	$sources_magic_directory  = abs_project_root($project_root) . $compiled_folder . $flex_folders;


// document root   has /           
// project  root   has / or is ''
// compiled folder has / or is ''
// flex     folder has / or is ''

function integrity_check_count($arr) {	// initial variables of program
										// Integrity Counts For Display	
	$backslash_conversions       = 0;
	$cwd_coversions              = 0;
	$double_forwardslash_warning = 0;
	$trailing_fowardslash_required_when_not_cwd_conversion = 0;

	$backslash_conversions       = backslash_conversions_count($arr);
	$cwd_coversions              = cwd_varieties($arr);
	$double_forwardslash_warning = double_forwardslash_warning_count($arr);
	$trailing_fowardslash_conversion = adds_trailing_fowardslash_when_not_cwd_count($arr, True); // trailing_fowardslash_required_when_not_cwd_conversion
																								 // remove the True parameter if you prefer using . as your cwd 
	print '<pre>';  // anyway, inner pre tags are when outer pre tags are not used, no affect when using pre tags twice on text	(i.e., can remove inner pre tags when using outer pre tags)														 
	print '<h1 style="font-size: 125%;">Integrity checks (0 is better for each) (cwd and double forwardslash perhaps are ok (depending on preference or situation))</h1>';
	print '<b> Backslash conversions issues (errors): <pre style="display:inline">( '.$backslash_conversions.' )</pre></b><br>';
	print '<b> Trailing forwardslash missing, conversions issues (errors): <pre style="display:inline">( '.$trailing_fowardslash_conversion.' )</pre></b><br>';
	print '<b> cwd conversions = <pre style="display:inline">( '.$cwd_coversions.' )</div> </b><br>';
	print '<b> Double forwardslash potential warnings: <pre style="display:inline">( '.$double_forwardslash_warning.' )</pre> </b><br>';
	print '</pre>';
	print '<br>';
}





function adds_trailing_fowardslash_when_not_cwd_count($arr, $include_cwd_warnings = false) {
	
	$count = 0;
	
	foreach($arr as $value) {
		//print 'directory=' . $value . '<br>';
		if ($include_cwd_warnings)
			if ($value == '.')
				$count++;
			
		else if ( $value == '' )
			;
		else {
			(substr($value, -1) == '/') ?       ''     :  $count++ ;   // when trailing forwardslash already there nothing or it count it due to it not there
		}
	}
	return $count;
}


function backslash_conversions_count($arr){
	$count = 0;
	foreach($arr as $value){
		$count += count_substring('\\', $value);
	}
	return $count;
}

function count_substring($item, $s){
	
	$t = str_replace ( '', $item  , $s);

	if ( (contains ('\\', $s) == false) || $item == '' )
		return 0;
	
	return (strlen($s) - $strlen($t)) / 2;  // due to the error of an existing backslash being a length of two in php strings
}

function cwd_varieties($arr){

	$count = 0;
	foreach($arr as $value) {
		$v = $value;
		if ($v == '.' ||  $v == './' ||  $v == '.\\' || $v == '/' || $v == '\\')	// current working directory should be  '' (recommended, therefore this line not needed)  (perhaps needed if you insist on ./  or . as cwd)
			$count++;  		
	}
	return $count;
}


function double_forwardslash_warning_count($arr){
	print '<br>';
	$count = 0;
	foreach ($arr as $value){
		//print 'path='.$value . ' ------ ' .  findcount('//', $value) . '<br>';
		$count += findcount('//', $value);
	}
	return $count;
}


// directory that seems to not be just / i.e., dir/
function gets_document_root_with_trailing_fs(){ // ensures,guarentees trailing forward slash
	//print (substr($_SERVER["DOCUMENT_ROOT"], -1) == '/') ? $_SERVER["DOCUMENT_ROOT"] . '  document_root trailing forwardslash':$_SERVER["DOCUMENT_ROOT"] . '/' .'  no tfs, therefore just added it'.'<br>';
	return $_SERVER["DOCUMENT_ROOT"] .'/';	// integrity checks can verify, and add the forward slash
}

function abs_project_root($directory_of_project_root) {
	
	//return  b2f($_SERVER["DOCUMENT_ROOT"] .'/'. $directory_of_project_root) ;
	return   b2f(   gets_document_root_with_trailing_fs() . $directory_of_project_root) ;
}

												// document_root, project_root
function all_folders_after_project_root_until_index($project_root) { // depends on where index.php is
		
		
		$b = getcwd(); // of the file
		//$all_after_root  = b2f(  substr( $b, strlen( $_SERVER["DOCUMENT_ROOT"] )+1, strlen($b) )  );
		$all_after_root  = b2f(  substr( $b, strlen(gets_document_root_with_trailing_fs()) )  );
		
		$var = substr( $all_after_root , strlen($project_root) )     . '/'  ;
		
		// NOTE: the solution.
		// if not added to integity check tweak, this MUST be the solution ! (better to have in integerity check tweak though)  
		if ($var == '/')	// sort of a pseudo-all folders third root, therefore same algorithm # update-fix: 2015.02.17
		$var = '';			// reminder:  when /  therefore ''  
							// thus there are no middle folders between (document root + project root) and the index.php
							// integrity check would also resolve it by adding the forwardslash when required
	
		return  $var  ;
}


// simple_preprocessor.py options
$str_bool_uni_value = 'False';


function domain_name_endswith() {	  // or contains, domain_suffix, etc.    // or just argument to py code

$ret1 = 'A';    // plan
$ret2 = 'WIDE'; // B
	if(isset($_SERVER['SERVER_NAME']) ) {
		$s = $_SERVER['SERVER_NAME'];
	//  :D  Lee
		$s = right(raise($s), 2);
		if ($s == 'US')
			return $ret1;
		else
			return $ret2;
	}
return $ret1;
}

function to_write($file, $s){ 
	
	$filename = basename($file);
	
	if (not ($file == $filename) ) { // there's more to the filepath than just the file(presumes current path) (i.e., there's path also)
		$var = substr($file, 0,  strlen($file) - strlen($filename) );
		print 'creating_sub_folders_automatically : ( ' . $var . ' ) to the file: ( ' . $file . ' )' . '<br>';
		mk_dir_p( $var );
	}
	
	file_put_contents($file, $s); 
}

function not($s){return !$s;}
function findcount2($item, $s){ // works too, not using at this time
	$idx    =0;
	$count  =0;
	$lenit  =strlen($item);	
	$slength=strlen($s);
	while ($idx !== false) {
		if ( not ($idx < $slength) ){
		break;}
		$idx = strpos($s, $item, $idx);
		if ($idx === false){
		break;}		
		$count++;
		$idx += $lenit;
	}
	return $count;
}

//function findcount2 ($item, $s) { return substr_count($s, $item); } //works
function pysplit($item, $s)  { return explode( $item, $s);               }
function findcount($item, $s){ return count( pysplit ( $item, $s ) ) -1; } // note  -1 to subtract string itself
// backslash to forward-slash
function b2f($s) { return (str_replace('\\','/',$s)); } // optional on some OS environments, for platform independence
function to_read($file) { return file_get_contents($file) ; }
function contains ($needle, $haystack) { return strpos($haystack, $needle) !== false; }
function php_string_slicing($start, $end, $s) { return substr ($s,$start,$end - $start); }// yet_to_be_added
function underscore_to_space($s) { return str_replace(  '_' , ' ' , $s ); } // str_replace($old,$new,$s)
function raise($s) { return strtoupper ($s); }
function lower($s) { return strtolower ($s); }
function str_bool($s){ return ( ($s) ? 'True' : 'False'); }
function upper($s) { return strtoupper ($s); }
function without_file_extension($s) { return substr($s, 0, strrpos($s, ".")); } // without . and file extension
function right($str, $length) {return substr($str, -$length);  }

function mod_dt($file) {
	return date ("YmdHis", filemtime($file));
}

function is_compiled($source, $compiled) {
	
	echo 'source:' . $source . '<br>';
	echo 'compiled:' . $compiled . '<br>';
	
	if ( not( file_exists ($source) ) ) {
		echo "$source file does not exist, exiting";
		return false;
	}
	
	if ( not( file_exists ($compiled) ) ) {
		echo "$compiled file does not exist" . '<br>';
		return false;
	}
	
	if ( mod_dt($source) >= mod_dt($compiled) ){
		echo 'return false';
		return false;
	}
	else {
		echo 'return true';
		return true;
	}
}


function quick_dev_mode($s){
		file_put_contents( 'style.css'   , ''); //creates empty file
		file_put_contents( 'script.js'   , ''); //creates empty file
}

function mk_dir_p($s) {	// returns true if exists
	
	if (file_exists($s)) 	// is_dir()
		return 'exists';
	else {
		if (!mkdir($s, 0777, true))
			return 'error';
		else
			return 'made';
	}
	
	return false;
}

function make_this_folder($folder){
	
	if ($folder == '')
		return true;
	
	return mk_dir_p($folder);
}

function get_string_tag_to_tag($s, $opentag, $closetag=''){
	
	global $project_root;
	global $preprocessor_folder;
	
	$opentag  = underscore_to_space($opentag );
	$closetag = underscore_to_space($closetag);

	$beginpos = strpos( $s, $opentag);
	
	if ($beginpos === false) {
		echo "The string '$opentag' was not found in the string ";
	} else {
		//echo "The string '$opentag' was found in the string ";
		//echo " and exists at position $beginpos";
	}

	if ($closetag=='') {
		$end = strlen($s);				// to end of file
	}
	else {
		$end = strpos($s, $closetag);
	}
		
	
	if ($end === false) {
		echo "The string '$closetag' was not found in the string";
	} else {
		//echo "The string '$closetag' was found in the string ";
		//echo " and exists at position $end";
	}
	
	$start = $beginpos + strlen($opentag) + 1;
	$finish = $end; // same thing, though sometimes an offset 
	return php_string_slicing($start, $finish , $s);
}






$base_name_without_extension = without_file_extension(basename(__FILE__));
$source   = $base_name_without_extension . '.py';
$compiled = $base_name_without_extension . '_compiled.py';



for ($i = 1; $i <= 1; $i++)	// to mimic a function, can then use break, continue without need for global vars
if (not($done) ) {

	$s = to_read(__FILE__);

	$t = get_string_tag_to_tag($s, 	'#_START_SOURCE_CODE_OF_PY_PAGE_OUTPUT_#', 
					'#_END_SOURCE_CODE_OF_PY_PAGE_OUTPUT_#');

           
	$var = $base_name_without_extension . '.py';

	if (not (file_exists($var))){  /* this_page_name.py file (front.py) */
		$t = str_replace( 'PHP_OPEN_TAG_REPLACE', '<'.'?'.'php', $t);
		$t = str_replace( 'PHP_CLOSE_TAG_REPLACE', '?'.'>', $t);
		to_write($var, $t);
		$var_file1= true;
	}

	$u = get_string_tag_to_tag($s, 	'#_START_PRE_PROCESSOR.PY_WRITE_OUTPUT_#',
					'#_END_PRE_PROCESSOR.PY_WRITE_OUTPUT_#');
	

	$var = 'simple_preprocessor.py';
	if (not (file_exists($var))){
		to_write( abs_project_root($project_root) . $preprocessor_folder . $var , $u );
		$var_file2=true;
	}

	
	$u = get_string_tag_to_tag($s, 	'#_START_SIMPLE_PREPROCESSOR_AUTO_PRINT_LITERAL.PY_WRITE_OUTPUT_#');
									
	$var = 'simple_preprocessor_auto_print_literal.py';
	if (not (file_exists($var))){
		to_write( abs_project_root($project_root) . $preprocessor_folder . $var , $u );
		$var_file3=true;
	}	
	
	if($quick_development_mode) {  // quick dev mode simply puts the .css, .js, and .pyj in the same folder as source and index.php
		file_put_contents( $base_name_without_extension  . '.css'   , '');	//otherwise name them  style.css
		file_put_contents( $base_name_without_extension  . '.js'    , '');	//                    script.js
		file_put_contents( $base_name_without_extension  . '.pyj'   , '');	//                  pyscript.pyj   or  rapydscript.pyj
		break;
	}
	
	
	$include_dir = false;
	$include_dir_res = ( make_this_folder($include_folder) ) ? True : False; //break for early exit
	//if ($include_dir_res)	  //early exit works, when making the done feature
	//	break;
	
	$css_dir= false;
	$css_dir_res = ( make_this_folder($css_folder) ) ? True : False; //break for early exit
	//if ($css_dir_res)
	//	break;

	$js_rs_dir = false;
	$js_rs_dir_res = ( make_this_folder($js_rs_folder) ) ? True : False; //break for early exit
	//if ($js_rs_dir_res)
	//	break;

	
	if ($css_per_page_folder_using)
		mk_dir_p( $css_folder   .  $base_name_without_extension ); // creates folder with same name as this php file
	else
		file_put_contents( $css_folder  .  $base_name_without_extension  . '.css'   , ''); //creates empty file
	
	
	if ($js_rs_per_page_folder_using)
		mk_dir_p(  $js_rs_folder .  $base_name_without_extension  ); // creates folder with same name as this php file
	else
		file_put_contents( $js_rs_folder  .  $base_name_without_extension  . '.js'   , ''); //creates empty file
	
	
	if ($rs_per_page_file_using)
		file_put_contents( $js_rs_folder  .  $base_name_without_extension  . '.pyj'  , ''); //creates empty file
		

	if($quick_development_mode){ // not checking folders, but still precompiling... therefore, precompile before this.
		echo 'early exit using a mimic function';
		$done=true;
		break;
	}
	

}


	

	// previously was defining flex_folders and sources_magic_directory here though now near top for integrity check
	// and therefore the # update-fix: 2015.02.17 in the function all_folders_after_project_root_until_index now commented out is instead done by the integrity check (a bit better imo)

	// NOTE:    sources_magic_directory is created near at the beginning of the program due to it being a pseudo-third root (the other two being document_root and project_root)
	// note: sources_magic_directory a concatonation of document_root , project_root , and flex,dynamic_folders
	print '<br><br>SHOULD HAVE A TRAILING SLASH result  (' .  $sources_magic_directory  . ')<br><br>'; // third pseudo-root
		
	$sources_magic_directory_compiled =  $sources_magic_directory . $compiled;		// *_compiled.py
	
	// tmp
	//$dir_contents_what = abs_project_root($project_root) . $compiled_folder . $flex_folders ;
	//echo '<br>what is this directory, checking... <pre style="display:inline;"> (  ' . $dir_contents_what . '  )</pre><br>';
	
	
	if ( not( is_compiled($source, $sources_magic_directory_compiled ) ) ) {
	
	
		// when done is set, the folder check is still done due to perhaps the source and index files being moved to a different directory, the project will appear to be fine, but will not run unless the folder is created first before compiling the source 
		mk_dir_p(abs_project_root($project_root) . $compiled_folder . $flex_folders);    //This function is commented out because these folders are being made in the previous function when done variable is false
	
	
		print 'compiled_sources_magic_directory_path_also=( ' . $sources_magic_directory_compiled . ' )<br>';

	
			echo '(PYTHON COMPILING) compiled=('.$sources_magic_directory_compiled.')' . '<br>';//$compiled_folder
	
	
echo passthru(	'python '.abs_project_root($project_root).$preprocessor_folder.'"simple_preprocessor.py" -TW "'.$source.'" "'.$sources_magic_directory_compiled.'" "'.$str_bool_uni_value.'" 2>&1  && '.    
		'python '.abs_project_root($project_root).$preprocessor_folder.'"simple_preprocessor_auto_print_literal.py" "'.$sources_magic_directory_compiled.'" "'.str_bool($auto_print_wwwlog_literal).'"  2>&1 ' );

	}



//run it

echo '(ALREADY COMPILED)';

echo passthru('python "'.$sources_magic_directory_compiled. '" "' .domain_name_endswith().'"  2>&1 ');


?>

<?php

				// READ THIS !!!!
$msg = 'exit'; // change to '' to remove printing to screen   but KEEP THE NEXT STATMENT ON THE NEXT LINE
die($msg);    // stops php from reading additional contents of this file.



// edit of your web page occurs in the file with the same name as this file .py instead of .php
// directions:  the file that will contain your web site mentioned in the previous line will be created
//              automatically when FIRST running this page
?>

### NOTE: DO NOT CHANGE THE TEXT ON THE NEXT LINE!!!!
# START SOURCE CODE OF PY PAGE OUTPUT #

import os
import sys
from subprocess import PIPE, Popen, STDOUT
import time
import ast
import uuid

same_file = False	# is True or False , gets value from PHP (global or make App class due to        # Note, 2015.02.02: same_file set to True not recommended
                        # global variables frowned upon, i.e., not best practices)                   # because of the note comment explained in index.php
                        # began to import from PHP, still a todo, at this time
PRINTOUT = False	# for print statements used by print_test() to review variables, etc. for a form of browser console logging
					# 2015.01.30 added feature to allow python quick tags to triple quoted strings for assignment operators
					# triple quoted string can still be used, but not between <% and %> because they represent triple double quotes, and that would be
					# triple double quotes within triple double quotes (quotes within TDQ need to be escaped with the backslash)

print_literal = False

def findtags(open, close, s):
	t=[] #list,array,vector...
	idx=0
	item =''
	while(idx != -1):
	
		idx = s.find(open, idx)
		if idx == -1:
			#print 'break point #1 (open tag)'
			break;
			
		idx2 = s.find(close, idx+1)
		if idx2 == -1:
			#print 'break point #2 (close tag)'
			break;
			
		item = s[idx+len(open):idx2]
		t.append(item) # potential variable name
		#print 'result(' + item + ')'
		idx += 1
		item ='' # reset item
	return t
	
                  # utags will return the string with unicode type python quick tags ON as its initial value, by default.
                  # for convenience, the utags is a string object that creates a version of the source code when JavaScript is off as a transition until browser native implementation
class utags(str): # or unicode_show  ,  whichever is a more appropriate label

	def unicode_markup(self, bool=True):
		return self if bool else self.replace('<unicode>', '').replace('</unicode>','')

class Str_fv(str): # to allow text that appear as format variables
                   # that are not defined in the parameter list of the format method

	def format(self, *args, **kwargs):
		self  = self.replace('{', '{{').replace( '}', '}}')
		open  = '{{**{{'
		close = '}}**}}'
		var_names = findtags(open, close, self) # potential

		for item in kwargs:
			for it in var_names:	#lookup after this working...
				if  item == it:
					self = self.replace(	open+item+close ,  (open+item+close).replace(open, '{').replace(close, '}'  ) )
					continue
		#print self
		#to_write('str_fv_txt.py', self) # error checking
		
		return     str( self ).format(*args, **kwargs)  # note:  .format method converts  {{ to {
	
	#nice
	def to_write(self, file):
		with open(file, 'w') as fp:
			fp.write(self)

			
class pyQuickTags(str):
	
	str_fv = Str_fv()
	
	def __init__(self, v):        # optional
		#v = v.replace('{', '{{').replace('}', '}}').replace('{{**{{', '{').replace('}}**}}', '}')
		#self = v         
		#print self
		self.str_fv = Str_fv(v)
	
	
	def format(self, *args, **kwargs):
		#print 'hello out there'
	
		return pyQuickTags(self.str_fv.format(*args, **kwargs)) # or init  str_fv()  at this point 
	

		#return     str( s ).format(*args, **kwargs)  # commented out
		#return super(pyQuickTags, self ).lower().format(*args, **kwargs)  # commented out
		# note, can wrap the super(pyQuickTags, self ) in a function e.g., something(super(str_fv, self )).format(*args, **kwargs)
		# or call an additional method as .lower does, etc.
	
	
	def htmlentities(self):
		salt = uuid.uuid4().hex
		s = self.replace('&quot;&quot;&quot;', '*QUOT-*-QUOT-*-QUOT*'+salt);
		code_init = r""" echo htmlentities('%s'); """  %  s.replace("'", "\\'")    # or using quick tags works too
		var = php(code_init)
		var = var.replace('*QUOT-*-QUOT-*-QUOT*'+salt, '&quot;&quot;&quot;')
		var = var.replace( '&amp;lt;%' , '&lt;%' ).replace( '%&amp;gt;', '%&gt;' ) # perhaps salt quick tags too
		
		#return var # this ok, perhaps to wrap return with pyQuickTags() to then allow another method call
		
		return pyQuickTags(var)
	
	#def to_print(self):  # one point of print out at this time, reduces complexity, simplier
	#	print self
		
	def to_write(self, file):
		with open(file, 'w') as fp:
			fp.write(self)	
			
def console_log_function():
	return <%
     /**
     * Logs messages/variables/data to browser console from within php
     * @param $name: message to be shown for optional data/vars
     * @param $data: variable (scalar/mixed) arrays/objects, etc to be logged
     * @param $jsEval: whether to apply JS eval() to arrays/objects
     * @return none
     * @author Sarfraz
     */
     function logConsole($name, $data = NULL, $jsEval = FALSE)
     {
          if (! $name) return false;
 
          $isevaled = false;
          $type = ($data || gettype($data)) ? 'Type: ' . gettype($data) : '';
 
          if ($jsEval && (is_array($data) || is_object($data))) {
               $data = 'eval(' . preg_replace( '#[\\a\\1\\2\\3\\4\\5\\6\\7\\8\\9\\b\\f\\v\\r\\n\\t\\0\\x0B]+#', '', json_encode($data)) . ')';
               $isevaled = true;
          }
          else {
               $data = json_encode($data);
          }
          # sanitalize
		  $data = $data ? $data : '';
          $search_array = array("#\\'#", '#\\"\\"#', "#\\'\\'#", "#\\n#", "#\\r\\n#");
          $replace_array = array('"', '', '', '\\\\n', '\\\\n');
          $data = preg_replace($search_array,  $replace_array, $data);
          $data = ltrim(rtrim($data, '"'), '"');
          $data = $isevaled ? $data : ($data[0] === "'") ? $data : "'" . $data . "'";
$js = <<<JSCODE
\n<script>
     // fallback - to deal with IE (or browsers that don't have console)
     if (! window.console) console = {};
     console.log = console.log || function(name, data){};
    // end of fallback
	// I innovated a start and end tag for hexadecimal content (the tag is of course arbitrary, though seems to fit the purpose (apropos))
	function not(s){return !s;}
	function hex2asc(pStr) {
		if (not( typeof pStr === 'string') )			// alert(typeof pStr);
		return pStr;
		var startHexTag = pStr.substr(0, 5);			// start tag to indicate hexadecimal content is <hex>
		var endHexTag = pStr.substr(pStr.length - 6); 	// end tag to indicate hexadecimal content is </hex>
		if ( not ( startHexTag === "<hex>" && endHexTag === "</hex>" ) )
		return pStr;
		var data = pStr.substring(5, pStr.length - 6 )
        tempstr = '';
        for (b = 0; b < data.length; b = b + 2) {
            tempstr = tempstr + String.fromCharCode(parseInt(data.substr(b, 2), 16));
        }
        return tempstr;
    }
     console.log('$name');
     console.log('------------------------------------------');
     console.log('$type');
     console.log(hex2asc($data));
     console.log('\\\\n');
</script>
JSCODE;
          echo $js;
     } # end logConsole
//echo( ' <br> {**{hello}**} <br>');	 
//echo( '{**{howdy}**}');
%>.format (  hello='hello world', howdy='very well thanks' )			
			
def rawstringify_outerquote(s):
    for format in ["r'{}'", 'r"{}"', "r'''{}'''", 'r"""{}"""']:
        rawstring = format.format(s)
        try:
            reparsed = ast.literal_eval(rawstring)
            if reparsed == s:
                return rawstring[1]
        except SyntaxError:
            pass
    raise ValueError('rawstringify received an invalid raw string')
	
def mod_dt(file):
	return time.strftime("%Y%m%d%H%M%S",time.localtime(os.path.getmtime(file)));
	
def to_write(file, s):
	with open(file, 'w') as fp:
		fp.write(s)					
					
def print_test(s):
	global PRINTOUT
	if (PRINTOUT):
		print s
		
def exists(path):
	return True if ( os.path.isfile(path) or os.path.isdir(path)) else False

def file_exists(path):
	return os.path.isfile(path)
	
def is_compiled(source, dest):

	if ( not file_exists(dest) ): # exists def nice, file_exists works fine too
		return False

	if ( mod_dt(source) >= mod_dt(dest) ):
		return False
	else:
		return True
		
def compile_include_quick_tags(file):
	global same_file
	
	if(not same_file):
		compiled = file[:-3] + '_compiled.py'
	else:
		compiled = file
	
	if ( is_compiled(file, compiled) ):
		#print '(INCLUDE ALREADY COMPILED)'
		return compiled
	
	print '(INCLUDE NOT compiled yet, therefore COMPILING)'
	
	os.system('"python.exe simple_preprocessor.py -TW '+file+' '+compiled+' whateverDNMfilterByoutputfunction 2>&1"')
	
	print_test( 'INCLUDING THIS FILE(' + compiled + ')' )
	return compiled # run pre_processor on it, with file being the source and  it as the dest
		
	# any includes done here to evaluate one file format variable, Q. can I include in a def,function
	
	
def include_quick_tags_file(source):
	global same_file
	
	print_test( 'POINT #1 file is:('+ source + ')' )
	f = os.path.abspath(compile_include_quick_tags(source)) # compiled variable
	print_test( '<br>file to include('+f+')' )
	
		# initially the idea was to compile here with the following statement:
		#execfile(compiled) # require fullpath, includes file   (though having a scope issue here)
				
	#if (same_file):
		# need to postprocessor.py the file after compiling
		# due to the way execfile currently works, cannot call from a def,function as I intend it to work (simply include)
	
	return f # hmm, how in -antastic is this, workaround needed by the receiver of this return when same file format is true


def execfile_fix(file): # workaround, due to execfile not working (as i'd like it to work (as expected)) from within a def,function
	global same_file
	
	if(same_file):
		os.system('"python.exe simple_postprocessor.py -TW '+file+' 2>&1"');


		
# INCLUDES TO BE PLACED HERE

file_to_include = 'include.py'
# including this way due to execfile does not including a file within a def,function as I expected
#execfile(include_quick_tags_file(file_to_include))	# this functin used to include each python file with quick tags		 


# NOTE: include section of source code with two entries due to workaround needed for execfile def,function
#execfile(include_quick_tags_file(file_to_include))
#execfile_fix(file_to_include) # when same file format is used, post_procesor.py (not used when using different file format)
                              # NOTE: fix does not need to be removed if using different file format (due to boolean check)
                              # otherwise, workaround is to convert after output() def called from main, with list of include files to convert back


def print_wwwlog(s, literal = True):    # prints to brower's console log
	
	if (literal):
		quote = rawstringify_outerquote(s)   # these 5 statements will occur when we turn on the  print_literal option
		if (quote == '"' ):                  # or    literal = True     
			s = s.replace('\\"', '"')        #
                                             # as of at this moment, it converts each print_wwwlog statement to
		if (quote == "'" ):                  # raw string literal with a new and innovative  simple_preprocessor_auto_print_literal.py  step
			s = s.replace("\\'", "'")        # the reason is to output messages to the brower console without escaping (actually its the most minimal escaping required)
                                             # see the comment about "TWO SMALL CASES TO ESCAPE WITH RAW STRING LITERALS" down below
											 
	# not to encode to ascii, better to use raw strings 
	#if (not esc_sequences_already):     # to get close to wysiwyg --   and perhaps innovative, Unicode tags proposed
	#	s = 'Lee: ' + s.encode('ascii')  # just to write lines, used during programming, statement can be removed
                                         # the way print_wwwlog() works is that it will either print ascii messages to the console or, you can escape characters, 
                                         # that will give you the same result, that will have to be interpreted anyway at the web browser as unicode,
                                         # perhaps put <unicode></unicode> and or <utf8></utf8> tags (and their uppercase forms) that I have arbitrarily innovated around utf8 strings to identify that.
		s = s.encode('hex')              # though perhaps browser's would identify that, or not, otherwise comment tags could be put around the unicode tags just mentioned <-- --> and javscript would convert to the required unicode text characters
		s = '<hex>'+s+'</hex>'           # if newlines actually needed, then there's use of html tags, e.g., <br> and so on... (perhaps even arbitrary tags for things like tabs <tabs> defined by css and so on...)
		
	code_init = <%
$name1 = '%s';
logConsole('$name1 var', $name1, true);
%> % s
	wwwout = code_init + "\n" + console_log_function()
	print php(  wwwout  ) # to web
					  					  
def print_args(s, intro=''):
	print_test( intro )
	for item in s:
		print_test( 'ARG:(' + item + ')' )
		
def create_superglobals(args):
	global same_file
	# idea to transfer superglobals from PHP here
	
               # experimental, just testing PHP called within Python
def php(code): # shell execute PHP from Python (that is being called from php5_module in Apache), for fun...
	p = Popen(['php'], stdout=PIPE, stdin=PIPE, stderr=STDOUT) # open process
	o = p.communicate('PHP_OPEN_TAG_REPLACE '+ code +'\n PHP_CLOSE_TAG_REPLACE')[0]
	try:
		os.kill(p.pid, signal.SIGTERM)	# kill process
	except:
		pass
	return o

def source_code():   # note, this is just source code print to display, not the entire page of the function output prints to the web browser, screen
	return <%
<html>
</head>
<script type="text/javascript">
	alert('hello world');
	// when using jquery then the next line
	//$(document).ready(function() {
		//console.log( "ready!" );
		//alert('hello world');
	//});
</script>

</head>
<body>
<h1>hello world</h1>
<br>
page contents here
and more of the website too
<b>have a great day!</b>
<br>
</body>
</html>
	
%>.htmlentities()
	
def top_content():
    
	print_wwwlog( '''I am at " the top " content''' ) # NOTE: better to use triple single quotes , best to put a space before and after a triple quoted string (though not necessary for triple SINGLE quotes)
	                                                  # (the open and close quick tags (< % % > with no spaces) to denote a 
                                                      # triple double quoted string ONLY for return and assignment statements at this time) 
                                                      # due to a space needed before closing parenthesis 
                                                      # when using triple DOUBLE quotes (no restriction with triple SINGLE quotes by you, the programmer)
	# at this time, one or no spaces between open parenthesis and open quick tag (no resriction on the close python quick tag as far as spaces around it)
	print_wwwlog ( <% example of new feature using quick tags between parenthesis %> )
	
	return ' pyTron    @    www.pytron.us '
	
def mid_content():

	print_wwwlog( r'''I am " at """" \'\'\'\'\'\'\'{}{}{}{} {{{{ }}}} the middle content \a\1\2\3\4\5\6\7\8\9\b\f\v\r\n\t\0\x0B
	
	
I have denoted newlines within a raw string , sent to the web browser that also interprets as newlines
And saving the file also is fine.

<br>
<br>
hello world  (but html characters are not interpreted this way)
'''    )  # TWO SMALL CASES TO ESCAPE WITH RAW STRING LITERALS, a backslash before a single quote or double quote 
          # (depending what are the outer quotes) and if the intent is to have a backslash at the end of a string, need two of them

	return <%
	
This is a test, <br>it is actually within a triple double quoted string
{**{testing}**}
%>.format( testing = 'HELLO WORLD(testing)' )
	
def end_content():
	return 'footer'
	
# in the case not transferring data from php using multiple domains, simply revert to a previous version, commit 
def domain_name(s):   
	if(s == 'A'):
		return 'us'
	elif(s == 'WIDE'):
		return 'com'

# no longer using due to pyQuickTags class,object replaces this function
def training_wheels_bit_slower_to_remove(s): # recommend: to remove this function for production code and edit code as required
                                             # just chose an arbitrary tag to represent the python format variables, works nicely, for now
	return s.replace('{', '{{').replace('}', '}}').replace('{{**{{', '{').replace('}}**}}', '}')

# test example, don't forget to have php.exe and php5ts.dll in PATH
width = 100
height = 100
code = <%

echo ('   {**{php_width}**}, {**{php_height}**}  ');

%>.format( php_width = str(width) , php_height = str(height) )

# Note, any JavaScript or any other code that contains a curly brace 
# must double the curly brace when using the python format function with the triple double-quoted string, 
# but not in a JavaScript src file (regardless of using the format function or not).

# It further verifies that the compiled Python-like RapydScript JavaScript will indeed run,
# with the use of jQuery's .ready and .getScript that also verifies the JavaScript is syntactically correct.
# If it is correct to the browser's JavaScript engine, the console.log will successfully print to the browser's console.


def output(name):
# With this New Feature: Open and Close Tags for this Python file 
# (It allows syntax highlighting within the tags, and eases coding)
# Note that the following opening tag, (less-than sign and percent sign) will be replaced by the simple_preprocessor.py
# with this:  PRINT training_wheels_bit_slower_to_remove(""" (lowercase) NOTE: this exact comment line obviously does not run.
	<%

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
<script src="js/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/page_frame_{**{domain}**}.css" />
<script src="first.js"></script>

<script>
$(document).ready(function() {
	console.log('jquery 1.11.2 initialized');
	console.log('app.js loading...  if capitalized done. statement does not appear next, or as the print line to the console, there is an error occurring');
});

jQuery.getScript("first.js", function() {
	console.log('DONE.');
});
</script>

</head>
<body>
Saying Hello World To Everybody!
<div id="container">

<div id="top">{**{top_content}**}</div>

<div id="mid">{**{mid_content}**}</div>

<div id="end">{**{end_content}**}</div>

</div>


Note that characters that before needed to be escaped now can be displayed in source code and to the screen will display as text as wysiwyg (what you see is what you get)
\\a\\1\\2\\3\\4\\5\\6\\7\\8\\9\\b\\f\\v\\r\\n\\t\\0\\x0B
\a\1\2\3\4\5\6\7\8\9\b\f\v\r\n\t\0\x0B   
This eases the coding of a webpage to increase productivity while reducing errors.
It speeds up iteration so you can achive more from your website.

<br>
PHP test: {**{php_test}**}
</body>
</html>


<unicode>hello world</unicode>



<br><br><br><br>

<b>Any Characters permissible within python quick tags &lt;% %&gt; (strings), neat</b>

Though this to note:
&lt;% %&gt; , allows quick tags between quick tags though must be in html entities form

''' triple single quotes allowed also '''
""" triple double quotes now allowed within python quick tags, feature added 2015.02.08 """


<h1>Example Of Displaying Source Code</h1>
{**{source_variable}**}  This format variable (see your_page.py) is processed, it's converted to htmlentities
feature added to pyQuickTags to htmlentities any python quick tags &lt;% %&gt; (string) (Note: only python quick tag &lt;% %&gt; strings MUST be converted, the rest optional for display purposes), feature added 2015.02.17
(Note: To not .htmlentities the contents of the page itself within the &lt;head&gt;&lt;/head&gt; section of html tags, javascript between python quick tags &lt;% %&gt; , etc. ) 
(htmlentities can be used for many purposes, such as to display source code blocks of code)

quick way to html entities a string {**{example_htmlentities_string}**}

While still compatible with being able to use python format variables,
{**{ python quick tags format variable now as wysiwyg text when undefined in format method parameters, feature added 2015.02.16 }**}


{**{     var    }**}


%>.format (   #  %:)>    # UNCOMMENT POINT *A* (uncomment the FIRST comment hash tag for the remove unicode operation   # the arbitrary find string is exactly this 20 characters long, quick workaround to subtract a parenthesis keyword operator # happy face keyword to rid a frown ( removes a close parenthesis ) (an arbitrary keyword created to remove one text character)
	# variables used
	top_content = top_content(),
	mid_content = mid_content(),
	end_content = end_content(),
	php_test    = php(code),  # just testing, remove if coding anything serious
	
	domain      = domain_name(name), # or something like whether a mobile device,
                                     # resolution information, etc. to select which css that fits	


source_variable = source_code(),

example_htmlentities_string = <%  <p><hello world note p tags output><p>  %>.htmlentities() # note, python quick tags stings have .htmlentities method

)

#.htmlentities()


#.replace( '&amp;lt;%' , '&lt;%' ).replace( '%&amp;gt;', '%&gt;' )



# 

 # %%>    # UNCOMMENT POINT *B* (uncomment the FIRST comment hash tag for the remove unicode operation)                                           

# html entities form of <% %> are to be used within python quick tags of <% %>     that     are       &lt;% %&gt;  at this time,  Note: this may be a concern, and htmlentities any string containing that will convert it to &amp;lt;% %&amp;gt;
# Therefore a feature to be implemented is to address that automatically for convenience

# statements marked by UNCOMMENT POINT *A* and *B* uncomment to remove unicode type quick python tags i.e., <unicode> </unicode>  though the contents in between the tags remain intact
#.unicode_markup()	# this is the method to remove the unicode type python quick tags, and give it a False argument
					# the utags wrapper already is automatically created
					# Usage:
					# place the keyword False in between .unicode_markup() parenthesis to remove the unicode type python quick tags,
					# i.e., to drop the <unicode> and </unicode> tags but not the contents,text between the tags
					# by giving the method unicode_markup() the argument of False it will remove the unicode tags
					# (by removing the argument or by setting it to True that is the same thing) the unicode tags remain intact.
					# (See front_compiled.py in github commit #47 of this project that I specially modified to show a working usage example)
					# Otherwise, modify this latest version according to usage description
					
	# testing writing print statement to the web browser 
	# the intent is to create a python function to wrap the writing with print statements to the web browser's console
	code_init = <%
$name = 'Stan Switaj';
 
$fruits = array("banana", "apple", "strawberry", "pineaple");
 
$user = new stdClass;
$user->name = 'Hello 123.00 \\a\\1\\2\\3\\4\\5\\6\\7\\8\\9\\b\\f\\v\\r\\n\\t\\0\\x0B ';
$user->desig = "CEO";
$user->lang = "PHP Running Through subprocess (Python)";
$user->purpose = "To print log messages to the browser console messages to the browser";
// var_dump($fruits);	// uncomment to display the array 
logConsole('$name var', $name, true);
logConsole('An array of fruits', $fruits, true);
logConsole('$user object', $user, true);
%>


	# Written to print to the console log of a web browser

	# Including an external python file that uses quick tags, (both open and close tags), and a format string variable syntax of {**{variable_name}**}
	
	s = (code_init + "\n" + console_log_function()  )
	
	# Escaping quotes seem to be the only small hassle from converting php source code to php source code within a python triple quoted string 
	# (due to the slightly obtuse (yet it works) situation of... running PHP then system calling Python and within it, running PHP within a python triple quoted string)
	# therefore, NOTE: the extra backslash compared with the php version
	# this will convert it to the exact php, but I've no need of it at this time, though note the following variable name in the comments (the immediate next line)
	# string_to_write__NOT_DISPLAY_for_exact_PHP_equivalent_source_code = s.replace("#\\'#", "#'#").replace('#\\"\\"#', '#""#').replace("#\\'\\'#", "#''#")   # works, tested
	# The previous statement string (in the comments) can be used to write if desired to get the exact PHP equivalent that is different than the string used to output to the web page 
	# (due to an extra backslash required by python for quotes)

	
	# For convenience I've included it in the following write statement anyway (to get the exact equivalent to the PHP source code string)
	# The next line is optional to the OUTPUT to Web (i.e., it will not affect the display OUTPUT to web 
	# (only for the previously stated purpose. So it's just to inspect and review the string by writing it to a file)
	s = s.replace("#\\'#", "#'#").replace('#\\"\\"#', '#""#').replace("#\\'\\'#", "#''#") # comment this line out to view the exact string that gets OUTPUT to the web
	
	#to_write('testit.txt', s ) # uses to determine problematic characters only, can be removed, and to verify the contents of a php string by outputing to a file
	
	# Sidenote: I did update the original regex and removed the \s to allow spaces and its noteworthy that it only needs one backslash to escape the string
	# as well as extended the regex just for demonstration to cover the escape characters commonly used
	# this is how the original regex should be escaped:     '#[\s\\r\\n\\t\\0\\x0B]+#'       and works (note remove the \s to allow spaces) 

	# TO OUTPUT to web
	print php(  s   )


	# ALSO NOTE: On the line immediately starting with the (percent sign and greater-than sign), this is the closing tag
	# gets replaced back to (triple double quotes and open parenthesis, in the situation when the same_format is set to true)

if __name__ == "__main__":  # in the case not transferring data from php, then simply revert to a previous version, commit
	create_superglobals(sys.argv)
	print_args(sys.argv, '<br>HERE front.py '+'<br>')
	
	if( not len(sys.argv) >= 2 ):
		print "argument is required, which domain name from the initial, starting PHP"
		sys.exit(1)
		
	output(name=sys.argv[1])


	
	
#   https://sarfraznawaz.wordpress.com/2012/01/05/outputting-php-to-browser-console/
#   http://stackoverflow.com/questions/843277/how-do-i-check-if-a-variable-exists-in-python same as
#   to test variable existence http://stackoverflow.com/a/843293  otherwise .ini for initial options
#   nice unicode description: https://greeennotebook.wordpress.com/2014/05/24/character-sets-and-unicode-in-python/


# END SOURCE CODE OF PY PAGE OUTPUT #
### NOTE: DO NOT CHANGE THE TEXT ON THE PREVIOUS LINE!!!!



### NOTE: DO NOT CHANGE THE TEXT ON THE NEXT LINE!!!!
# START PRE PROCESSOR.PY WRITE OUTPUT #


import sys
import re

option_auto_trailing_backslash_doubleit = True  # when True,  resolves by converting trailing \ to \\     (alternative method is setting to False)
                                                # when False, resolves by adding a space to end of python quick tag string to auto resolve python not allowing trailing backslash in triple quoted string
                                                # either is ok, works
def print_args(s):
	for item in s:
		print 'ARG:(' + item + ')'
		
def print_tuple(u):
	for item in u:	
		#print item                              # this will print  the raw string literal version of it (newlines shown as \n literally text displayed in command line text)
		print str( item[0] ) + ' ' + item[1] + '<br>'    # this      prints the escaped version of it (e.g., newlines wrap)

def print_tuple_4i(u):
	for item in u:	
		#print item                              # this will print  the raw string literal version of it (newlines shown as \n literally text displayed in command line text)
		print str( item[0] ) + ' ' + item[1] + ' ' + item[2] + ' ' + str( item[3] )

def makes_tuple_find(s, item, previous_text_character_length=0):
	idx=0
	t=[]
	while(1):
		i = s.find(item,idx)
		
		if (i== -1):
			break
		
		if (i == 0): # in the case of /%>    i then is 0
			t.append( ( i, 'FALSE_START' + s[0:i+len(item)] ) )
		else:
			t.append( ( i , s[i-previous_text_character_length:i+len(item)] ) )
		idx = i+1
	return t
	
def reverse_tuple_list(t):
	v=[]
	l = len(t)
	idx = l
	for x in range(l):
		v.append( ( t[idx-1][0] , t[idx-1][1] ) )
		idx = idx - 1
	return v
	
def make_quad_tuple_find_between_tags_reverse_order(s, opentag = '<%', closetag = '%>'):
	
	arr = makes_tuple_find(s, opentag)
	
	arr2 = reverse_tuple_list(arr)

	tup = []
	for item in arr2:
		
		tmp = item[1]
		idx = item[0]
		res = s.find(closetag, idx) # can do idx+2 to be exact

		if res == -1:
			print 'early exit, cannot find closing python quick tag'
			sys.exit(1)
			
		tup.append( ( item[0], item[1], '%>', res ) )
	return tup		

	
def auto_backslash_escape_adjacent_to_python_quicktag(s, array_of_tuples_in_reverse_order , thing): # adjacent to the closing python quicktag   %>
	t = s+' '  # just an exercise to not modify the original,  otherwise  s works too
	t = t[:-1] # to create a new string , otherwise perhaps     t = s[:]  e.g., http://www.python-course.eu/deep_copy.php
	for i in array_of_tuples_in_reverse_order:

		if i[1] == thing: #ok, that the required result
			print 'yes'                                     # then an edit to the source code will only occur when a count > 0
		else:
			t = t[: i[0]+1  ] + '\\' + t[  i[0]+1  :]
	
	return t
	
def findindices_of_nonwhitespace(s): # string  , returns tuple  (index and item) , this function not used for now
                                     # split function  enhanced to also return the indices of each item 
	arr = s.split()
	t=[]
	for item in arr:
		i=0
		i = s.find(item, i)
		t.append((i,item))
	return t		

def adjacent(itemA, itemB, new, s): # skips whitespace  # regrettably had to resort to this regex, required, therefore this function
	
	# something like this should be possible (using itemA and itemB)
	restr = itemA + r'\s{0,}' + itemB  # not using this string because,
	# due to the operation of regex and its variability it's due to escaping of characters and other reasons
	
	# therefore:
	return re.sub(r'\(\s{0,}<%', new, s)  # 0 to many spaces in between the ( and <%     #note: i had to escape the open parenthesis in this regex search
	
	
def algorithm(s, tw, uni_val=str(True) ):
	
	global option_auto_trailing_backslash_doubleit # when set to False adds space to resolve trailing backslash issue
	
	uni_str = '.unicode_markup('+uni_val+')'
	
	if (tw):
			#pyQuickTags now contains utags object, str_fv object, etc.
		
		s = s.replace('return <%', 'return pyQuickTags(r"""')
		s = s.replace('= <%', '= pyQuickTags(r"""')
		
        # note adjacent function for any number of spaces between ( and <%
		s = adjacent('(', '<%', '( pyQuickTags(r"""', s)
		
		s = s.replace('<%', 'print pyQuickTags(r"""')
#		s = s.replace('%%>', ')'+uni_str )    # UNCOMMENT POINT *C* (uncomment the FIRST comment hash tag for the remove unicode operation)      # to remove quick workaround, remove this line
		
		if(option_auto_trailing_backslash_doubleit): # an alternative to the algorithm2 solution that (resolves it by adding a trailing backslash) is 
			s = s.replace('%>','""")')              # to simply add a space to the end of the string at this exact point of the code (that modifies the compiled code only) that somewhat resolves the trailing backslash issue in python triple double quotes 2015.02.08
		else:
			s = s.replace('%>',' """)')     # adds a space 

#		s = s.replace('""")).format (     %:)>', '""").format (   #  %:)> ')    # UNCOMMENT POINT *D* (uncomment the FIRST comment hash tag for the remove unicode operation)     
		# about the previous line,  to remove quick workaround, remove this line, way to rid one close parenthesis, with the happy face keyword created for this purpose , it comments out the keyword %:)> 

		# statements marked by UNCOMMENT POINT *C* and *D* uncomment to remove unicode type quick python tags
		# uncomment to remove unicode type quick python tags i.e., <unicode> </unicode>  though the contents in between the tags remain intact
	else:
		s = s.replace('return <%', 'return utags(r"""')
		s = s.replace('= <%', '= utags(r"""')		
		s = s.replace('<%', 'print utags(r"""' ).replace('%>', '""")')		
	return s

def algorithm2(s):
										 # added: 2015.02.08 (feature to auto escape backslash for trailing raw literal triple double quotes to make it a valid python string)
	item1 = r'\\%>'                      # must be raw string literal
	arr1  = makes_tuple_find(s, item1 )
	item2 = '\%>'
	arr2  = makes_tuple_find(s, item2, 1)
	arr3  = reverse_tuple_list(arr2)     # to add a slash, from end to front so indices consistent
	s     = auto_backslash_escape_adjacent_to_python_quicktag(s, arr3, item1)
	return s 

def algorithm_to_allow_tdq_within_quick_tags(s, old='"""', new='&quot;&quot;&quot;'): # to allow triple double quotes within quick tags <% %>

	tup = make_quad_tuple_find_between_tags_reverse_order(s)

	for i in tup:
	
		s = s[:i[0]] + s[i[0]:i[3]].replace(old, new) + s[i[3]:]
		
		#s = s[:i[0]] + s[i[0]:i[3]].replace('"""', '&quot;&quot;&quot;') + s[i[3]:]

	return s

# the algorithm created by Stan "Lee" Switaj
def algorithm_to_allow_tdq_within_quick_tags_final_done(s, opentag, closetag, old, new ): # instead of regex, perhaps not going to be used

	tup = make_quad_tuple_find_between_tags_reverse_order(s, opentag, closetag)

	for i in tup:
		s = s[:i[0]] + s[i[0]:i[3]].replace(old, new) + s[i[3]:]
		
	return s


def modify_it(file, TW=False):
	
	global option_auto_trailing_backslash_doubleit

	with open(file, "r+") as fp:
		s = fp.read()
		fp.seek(0)
		
	if (option_auto_trailing_backslash_doubleit): # by converting trailing \ to \\   Otherwise alternative method to add space, i.e., set this variable to False at the top
		s = algorithm2(s)		

		if (TW):
			fp.write( algorithm(s,TW) )
		else:
			fp.write( algorithm(s,TW) )
		fp.truncate() # unnecessary, except when it is

def modify_diff(source, TW=False, dest='', uni_val=''):

	global option_auto_trailing_backslash_doubleit
	
	with open(source, 'r') as rp:
		s = rp.read()
	
	if (option_auto_trailing_backslash_doubleit): # by converting trailing \ to \\   Otherwise alternative method to add space, i.e., set this variable to False at the top
		s = algorithm2(s)
	
	
	s = algorithm_to_allow_tdq_within_quick_tags(s) # python quick tags are already the initial tags
		
	#s = algorithm_to_allow_tdq_within_quick_tags_final_done(s, '<%', '%>', '"""', '&quot;&quot;&quot;') # instead of regex

	with open(dest, 'w') as wp:
		if (TW):
			wp.write( algorithm(s,TW, uni_val) )
		else:
			wp.write( algorithm(s,TW) )
		
if __name__ == "__main__":  # in the case not transferring data from php, then simply revert to a previous version, commit
	# simply remove or comment out the print statements at your convenience, used just for debugging and testing purposes
	if( not len(sys.argv) >= 2 ):
		print "argument is required, which domain name from the initial, starting PHP"
		sys.exit(1)
	
	print (' Preprocessor ')
	print_args(sys.argv)
	
	if ( sys.argv[1] == '-TW' ):

		if ( len(sys.argv) == 3 ):
			modify_it( file=sys.argv[2], TW=True )
		elif( len(sys.argv) == 5):
			modify_diff( source=sys.argv[2], TW=True, dest=sys.argv[3], uni_val=sys.argv[4] )
		else:
			print 'python file is required'
			sys.exit(1)
	else:
		modify_it( file=sys.argv[1] )

		

### NOTE: DO NOT CHANGE THE TEXT ON THE NEXT LINE!!!!
# END PRE PROCESSOR.PY WRITE OUTPUT #
		

### NOTE: DO NOT CHANGE THE TEXT ON THE NEXT LINE!!!!
# START SIMPLE PREPROCESSOR AUTO PRINT LITERAL.PY WRITE OUTPUT #


# This begins the file simple_preprocessor_auto_print_literal.py
# this occurs after the initial simple_preprocessor.py step
# 
# therefore, front_compiled.py (or whatever its name is given
# by php ( or perhaps for include files also by python)
# flimsy at this time
import sys

def print_array(s):
	print 'Array items: '
	for x, item in enumerate(s):
		print str(x)+':('+item+')'
	print '<br>'

def is_found(s):	
	return False if s == -1 else True
   #return WHEN_TRUE_THIS  if EVALUATES_TO_TRUE  else  WHEN_FALSE_THIS

def repeat(s,times):
	return s * times if times > 0 else ''
	
def process(lines):
	#   example, (spaces ok)
	#   print_wwwlog('   is replaced with   print_wwwlog(r'
	#   print_wwwlog("   is replaced with   print_wwwlog(r"
	
	out = ''
	for line in lines:
		#s = line.split()      # or line.lstrip()  same thing    then  s[0]
		func = 'print_wwwlog'
		
		# the idea is     if ( '<%' in line and '%>' in line  )   # due to it already being converted to triple double quoted a raw string literal string
		# but because pre_processor.py runs first, therefore its the following:
		if ( '( pyQuickTags(r"""' in line and '""")' in line ):		# therefore, presuming that quick tags are being used
			out += line                             # therefore, not automatically adding r, already done
			continue
		
		if ( line.lstrip().startswith(func) ):  	#  .startswith(func)     same as      [:len(func)] == func    works 
			s   = line.find("'")
			d   = line.find('"')
			
			print '<br>LINE: (' + line + ')'		# print_array(s)
			
			val = -1
			if ( is_found(s) and is_found(d) ): 	# situation of both (all) exist in string
			
				if s < d:
					val = s
					print 'point #1 - IS FOUND (single quote) '
				else:
					val = d
					print 'point #2 - IS FOUND (double quote) '
			elif ( is_found(s) or is_found(d)  ): 	# one or other exist in string (not both)
			
				if is_found(s):
					val = s
					print 'point #3 - IS FOUND (single quote) '
				else:
					val = d
					print 'point #4 - IS FOUND (double quote) '
			else: # therefore neither exist in string i.e.,  not is_found(s) and not is_found(d)
					# exit somehow
					out += line   #  its an early go to next item in the loop,  can r literal strings within quotes  not variables or returned strings from function returns
					print '<br><br> Nothing found <br><br>'
					continue
			
			print 'VAL IS: ('+ str(val) + ')'
			print 'VAL VALUE IS: ('+ line[val] + ')'
			
			if ( is_found(val) ):					# determine if triple quoted string or not
				if line[val:val+3] == '"""':
					print '<br>its a triple double quote<br>'
					print 'TDQ=(' + line[val:val+3] +')'
					
				elif line[val:val+3] == "'''":
					print '<br>its a triple single quote<br>'
					print 'TSQ=(' + line[val:val+3] +')'
				else:
					print 'SITUATION IS: (' + line[val:val+3] + ')'
					
			paren = line.find("(")					# openparenthesis
			count = len(line[paren+1:val])
			print '<br>SPACE BETWEEN IS : COUNT : ' + str(count) + '<br>'
			
			result = line[:paren+1] + repeat(' ',count-1) + 'r' + line[val:]  # this is the line added with r
			print '<br>FINAL STRING IS  : ' + result + '<br>'
			
			
			out += result
		else:
			out += line
	
	return out
	# initially for every print_wwwlog(  then read its argument
	
# until exact, just going to use a 3rd file to review
def modify_it(file):   # received _compiled.py

	#with open(file, 'r+') as fp:
	#	lines = rp.readlines()
	#	data = process(  lines  )
	#	fp.seek(0)
	#	fp.write(   data   )
	#	fp.truncate()

	
	with open(file, 'r') as rp:
		lines = rp.readlines()  # includes newlines, otherwise  .read().splitlines()  removes newlines
		data = process(lines)
		
	with open(file , 'w') as wp:
		data = wp.write(  data  )
		

if __name__ == "__main__":

	if( not len(sys.argv) >= 3 ):
		print "argument is required"
		sys.exit(1)                  # import sys
		
	# sys.argv[1]      #argument received
	print '<br>'
	print 'SIMPLE_PREPROCESSOR_AUTO_PRINT_LITERAL file(' + sys.argv[1] + ')';
	print 'SIMPLE_PREPROCESSOR_AUTO_PRINT_LITERAL use, convert to auto literals, i.e., r the strings (' + sys.argv[2] + ')';
	# perhaps argument when you know not to forget the raw string escape keyword  r'  '
	if (sys.argv[2] == 'False'):
		print 'EXITING SIMPLE_PREPROCESSOR_AUTO_PRINT_LITERAL.'
	
	else:
		print '<br>'
		modify_it(sys.argv[1])		
		