<?php  
/* the page is the same name as the .py page */
	

// Description: Directories that use the internal routing of a web browser and allow to include from 
//              anywhere within a domain name without having the exact path to the include file

// EDIT THIS, this 
$project_root = 'test2/';			// when '' then it's document root (of domain name)  MUST put a trailing forward slash at the end of project root (should) 
							// use either '' (that is empty string) or some_directory/   (not forward slash by itself, i.e.,  '/' )
							//
							// set to project root, e.g., project_root = 'test2/';


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
foreach ($array as $key => $value) { echo "$key = $value\n<br>"; }
print '<br>';
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
foreach ($array2 as $key => $value) { echo "$key = $value\n<br>"; }
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
	$within_project_folder_warning = within_project_folder_check();	// critical though note its ok when project root is ''

	print '<pre>';  // anyway, inner pre tags are when outer pre tags are not used, no affect when using pre tags twice on text	(i.e., can remove inner pre tags when using outer pre tags)														 
	print '<h1 style="font-size: 125%;">Integrity checks (0 is better for each) (cwd and double forwardslash perhaps are ok (depending on preference or situation))</h1>';
	print '<b> Backslash conversions issues (errors): <pre style="display:inline">( '.$backslash_conversions.' )</pre></b><br>';
	print '<b> Trailing forwardslash missing, conversions issues (errors): <pre style="display:inline">( '.$trailing_fowardslash_conversion.' )</pre></b><br>';
	print '<b> cwd conversions = <pre style="display:inline">( '.$cwd_coversions.' )</pre> </b><br>';
	print '<b> Double forwardslash potential warnings: <pre style="display:inline">( '.$double_forwardslash_warning.' )</pre> </b><br>';
	
	print '<b> Not In Project Folder potential warning: <pre style="display:inline">( '. $within_project_folder_warning .' )</pre> </b><br>';
	print '</pre>';
	print '<br>';
}

within_project_folder_verifies($project_root);

function within_project_folder_verifies($project_root) {
	
	if ($project_root == '') {
		//print 'ok, its is empty string'.'<br.';
		return True;
	}
	
	print '<br>';
	print 'current doc root=' . lower(gets_document_root_with_trailing_fs()) . $project_root  . '<br>';
	print 'b2f cwd=' . b2f(lower(getcwd()))  .'/'. '<br>';
	
	if ( startsWith(lower(gets_document_root_with_trailing_fs() . $project_root ), b2f(lower(getcwd()) ) .'/') ) {
		return True;
	}
		
	print "early exit, this page must be within project root folder (or set project root to '' when this page at the document_root,context_document_root directory its ok then also)";
	exit;

	//return False;
}

function factored_getcwd() {
	
	$var =  substr(   b2f( getcwd() ) ,  strlen(    gets_document_root_with_trailing_fs()  )  ) . '/' ; // removes the document root (and the trailing slash) from cwd
	return $var;

}

function within_project_folder_check() {
	
	global $project_root;

	print 'project_root= ' . $project_root . '<br>';
	print 'getcwd= ' .  b2f( getcwd() ) . '<br>';
	print 'factored getcwd= ' . factored_getcwd() . '<br>';

	// perhaps if project root is '' then something...
	if ( startsWith( $project_root, factored_getcwd() )    ) {
		print 'yes, starts with, point #1'  . '<br>';
		return 0;	
	}
	else {
		print 'no, does NOT startwith, point #1' . '<br>';
		return 1;	//warning
	}
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



function gets_document_root_with_trailing_fs(){ // ensures,guarentees trailing forward slash

	
		//echo 'document root=' . $_SERVER["DOCUMENT_ROOT"] . '<br>';
		//echo 'context document root=' . $_SERVER["CONTEXT_DOCUMENT_ROOT"] . '<br>';

	if ( startsWith(lower($_SERVER["DOCUMENT_ROOT"]) , lower($_SERVER["CONTEXT_DOCUMENT_ROOT"]) ) ) {
		//echo 'YES ' . $_SERVER["DOCUMENT_ROOT"] . '<br>';
		return $_SERVER["DOCUMENT_ROOT"] .'/';
	}
	else  {
		//echo 'NO ' . $_SERVER["CONTEXT_DOCUMENT_ROOT"] . '<br>';
		return $_SERVER["CONTEXT_DOCUMENT_ROOT"] .'/';
	}


}

function abs_project_root($directory_of_project_root) {
	
	//return  b2f($_SERVER["DOCUMENT_ROOT"] .'/'. $directory_of_project_root) ;
	return   b2f(   gets_document_root_with_trailing_fs() . $directory_of_project_root) ;
}

function source_directory() {
	return b2f(getcwd());
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
function php_string_slicing($start, $end, $s) { return substr ($s,$start,$end - $start); }// yet_to_be_added
function underscore_to_space($s) { return str_replace(  '_' , ' ' , $s ); } // str_replace($old,$new,$s)
function raise($s) { return strtoupper ($s); }
function lower($s) { return strtolower ($s); }
function str_bool($s){ return ( ($s) ? 'True' : 'False'); }
function upper($s) { return strtoupper ($s); }
function without_file_extension($s){ return substr($s, 0, strrpos($s, ".")); } // without . and file extension
function right     ($str, $length) { return substr($str,   -$length);        }
function left      ($str, $length) { return substr($str, 0, $length);        }
function startsWith($sub, $string) { return (substr($string, 0, strlen($sub)) === $sub); }
function endsWith  ($sub, $string) { return (substr($string,   -strlen($sub)) === $sub); }
function contains  ($sub, $string) { return (strpos($string, $sub) !== false);           }

function mod_dt($file) {
	return date ("YmdHis", filemtime($file));
}

function to_compile($source, $compiled) {
	
	if (  file_exists ($source) == false ) {
		echo "$source file does not exist, exiting";
		exit;	// if you delete the  source.py (front.py) file, but keep the _compiled.py file for perhaps a (strange) reason,    return false;   instead of  exit;
	}
	
	if ( file_exists ($compiled) == false ) {
		echo "$compiled file does not exist" . '<br>';
		print 'COMPILING NOW! (a)' . '<br>';
		return true;
	}
	
	if ( mod_dt($source) > mod_dt($compiled) ) {
		print 'COMPILING NOW! (b) source has been edited ' . $source . '<br>';
		return true;
	}
	else
		return false;
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
		to_write($var, $t);
		//$var_file1= true;
	}



	$u = get_string_tag_to_tag($s, 	'#_START_PRE_PROCESSOR.PY_WRITE_OUTPUT_#',
					'#_END_PRE_PROCESSOR.PY_WRITE_OUTPUT_#');
	
	$var = 'simple_preprocessor.py';
	if (not (file_exists( abs_project_root($project_root) . $preprocessor_folder . $var ))){
		to_write( abs_project_root($project_root) . $preprocessor_folder . $var , $u );
		//$var_file2=true;
	}



	
	
	$v = get_string_tag_to_tag($s, 	'#_START_PRE_PYTHOR_FEATURES.PY_WRITE_OUTPUT_#',
					'#_END_PRE_PYTHOR_FEATURES.PY_WRITE_OUTPUT_#');
	
	$var = 'simple_preprocessor_pyThor_features_txt.py';
	if (not (file_exists( abs_project_root($project_root) . $preprocessor_folder . $var ))) {
		$v = str_replace( 'PHP_OPEN_TAG_REPLACE', '<'.'?'.'php', $v);     # removed closing tag, unnecessary (sometimes errors also, the \n): 02-21-2015
		to_write( abs_project_root($project_root) . $preprocessor_folder . $var , $v );
		//$var_file3=true;
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
	
	print '<br>';
	print 'source=' . $source . '<br>';
	print 'sources_magic_directory_compiled=' . $sources_magic_directory_compiled . '<br>';

	
	


	
	
	
	
function strToHex($string){ $hex = ''; for($i=0; $i < strlen($string); $i++){$hex .= sprintf( "%02x", ord($string[$i]));} return $hex; }
	
function micro(){return explode( '.' , microtime(True))[1];} // nano perhaps, etc.

function dosprompt_limitworkaround($num){	return $num < 8000;	}            // (due to dos prompt workaround limit to send text over dos prompt (command line) console)

function superget()    { return json_encode($_GET);    }
function superpost()   { return json_encode($_POST);   }
function superfiles()  { return json_encode($_FILES);  }
function superglobals(){ return json_encode($_SERVER); }

// before hex conversions
$var_superget     = superget();
$var_superpost    = superpost();
$var_superfiles   = superfiles();
$var_superglobals = superglobals();

$supercount = ((strlen($var_superget)+strlen($var_superpost)+strlen($var_superfiles)+strlen($var_superglobals)) * 2) ;	// hex overhead (a side todo to get exact ratio)
//print 'Totals (hex length): (' + $supercount + ')';



$filename_superglobals = 'pyThor_superglobalvariables'.micro().'.txt';    // perhaps a virtual in-memory file solution 
if ( dosprompt_limitworkaround($supercount) ) {                                    //  (due to dos prompt workaround limit to send text over dos prompt (command line) console)
	$var_superget     = strToHex($var_superget);
	$var_superpost    = strToHex($var_superpost);
	$var_superfiles   = strToHex($var_superfiles);
	$var_superglobals = strToHex($var_superglobals);	
}
else {	
	file_put_contents(  $filename_superglobals, $var_superglobals . "\n" . $var_superget . "\n" . $var_superpost  . "\n" .  $var_superfiles );
	$var_superglobals = 'file';
	$var_superget     = $filename_superglobals;
	
	$var_superpost='';
	$var_superfiles='';
}



//$source = 'front.py';
//$compiled = 'front_compiled.py';

//comment out!! or remove this code, developer convenience code, internal features developer code
$bool_recompile_feature_edit = false;
$features_file = 'simple_preprocessor_pyThor_features_txt.py';

$bool_recompile_feature_edit = to_compile( abs_project_root($project_root) . $preprocessor_folder . $features_file, $sources_magic_directory_compiled);  // AND REMOVE THE  ||  boolean on the next statement
// NOTE: when developing internal features, note the next statement to uncomment, the next if statment ( approx. 7 lines down, it is a if statement with the boolean or ) (it is commented out) (it is so compiling will occur when the simple_preprocessor_pyThor_features_txt.py file is edited)
//comment out!! or remove this code, developer convenience code, internal features developer code
//
//
//
// NOTE: simple_preprocessor_pyThor_features_txt.py MUST be in the same folder as simple_preprocessor.py
// NOTE: TW is now pyQuickTags a feature built-in,intrinsic (internal now as a feature)
//    past tense
if (  to_compile($source, $sources_magic_directory_compiled)  ||  $bool_recompile_feature_edit ) {  // NOTE: this is for an internal developer statment to recompile when simple_preprocessor_pyThor_features_txt.py is edited (therefore comment out the next line as needed)
//if (  to_compile($source, $compiled) ) {       

	// when done is set, the folder check is still done due to perhaps the source and index files being moved to a different directory, the project will appear to be fine, but will not run unless the folder is created first before compiling the source 
	mk_dir_p(abs_project_root($project_root) . $compiled_folder . $flex_folders);    //This function is commented out because these folders are being made in the previous function when done variable is false
	print 'compiled_sources_magic_directory_path_also=( ' . $sources_magic_directory_compiled . ' )<br>';	
	echo '(PYTHON COMPILING) compiled=('.$sources_magic_directory_compiled.')' . '<br>';//$compiled_folder
	print 'preprocessor folder=' . $preprocessor_folder . '<br>';
	print 'compiled file=' . $sources_magic_directory_compiled . '<br>';
	
	
	echo passthru( 'python '.abs_project_root($project_root).$preprocessor_folder.'"simple_preprocessor.py" -M "'.$source.'" "'.$sources_magic_directory_compiled.'" "'.$str_bool_uni_value.'" 2>&1 ');
}
else {
	;//echo '( NOT compiling!!!)';
}

//echo '(ALREADY COMPILED)<br>';


echo passthru('python "'.$sources_magic_directory_compiled. '" "' .domain_name_endswith().'" "'. $var_superglobals . '" "' . $var_superget . '" "' . $var_superpost  . '" "' . $var_superfiles . '" "'.  abs_project_root($project_root).$preprocessor_folder  .'" "'. source_directory() .'" 2>&1 ');


if ( ! dosprompt_limitworkaround($supercount) ) {		// note: negation
	if ( file_exists($filename_superglobals) )
		unlink ( $filename_superglobals );
}


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

# pyTron (pyThor) page
# Internal are these functions that you can use, the source code to view is in the file  simple_preprocessor_pyThor_features_txt.py
#                                                   the compiled version is in the file  front_compiled.py
#                                                   for review

#  1)     python quick tags  <%  %>
#  2)                              .htmlentities()   on the python quick tags          (to display source code) (note to wrap your format variable in pre tags for newlines work ok)

#  3)     source_code_from_file(file)                # file is the filename of the source code you would like to display

#  4)     use of superglobal variables from PHP in the form of pySERVER,pyGET,pyPOST,pyFILES as accessed in PHP
#         Though recommended for convenience is to use the name of the variable that is global 
#         e.g.,  Recommended use  DOCUMENT_ROOT  this is a global variable, instead of pySERVER['DOCUMENT_ROOT'], and so on (to access other PHP superglobal variables)
#         Please note that the keyword global must be used to access the superglobal variable within any function or method that you intend to use the variable.

#  5)     print_wwwlog(any_text_to_print_to_console_log_string_or_variable_etc)    # prints to brower's console log

# Note:  The variable   ensure  is set to True inititally, this can be set to False for a slight speed increase in the  simple_preprocessor_pyThor_features_txt.py  file ) ( also note: python allows to overwrite functions by simply making a function by the same name in this file as is defined in the simple_preprocessor_pyThor_features_txt.py file, though not recommended)


#  List Of PyThor features
#  -----------------------
#       From the .php file     *.php?pagesource       to display the actual page source code of the webpage (without the source code to the core pyThor features)
#                              *.php?fullsource       to display the full source code of a webpage similar to the view source as feature of web browsers 
#                              *.php?pythorinfo       to display the environment variables of the web server, e.g., pySERVER, pyGET, pyPOST, and pyFILES
#                              *.php?features         to access the feature list
#                                   
#
#       Note that each of these url get parameters are easily configured that can be removed as shown in the example source code page auto created initially (note the .format method of the main function output )


# INCLUDES TO BE PLACED HERE
file_to_include = 'include.py'
#execfile(include_quick_tags_file(file_to_include)) # including this way due to execfile does not include file from within a def,function


def source_code():    # note, this is to display whatever source code is within this function
	
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
    
	print_wwwlog( <% top content string %> )
	
	print_wwwlog ( <% example of new feature using quick tags between parenthesis %> )
	
	return ' pyThor    @    www.pyThor.us '
	
def mid_content():

	print_wwwlog( <% middle content string 

<br>
<br>
hello world  (but html characters are not interpreted this way)
%>    )

	return <%
	 
{**{var_msg}**}

%>.format( var_msg = 'HELLO WORLD - PyThor for Web Programming' )
	 
def end_content():
	return 'footer'
	
 
def domain_name(s):   
	if(s == 'A'):
		return 'us'
	elif(s == 'WIDE'):
		return 'com'


# PHP from pyTron (pyThor)
# test example, don't forget to have php.exe and php5ts.dll in PATH
width = 100
height = 100
code = <%

echo ('   {**{width}**}, {**{height}**}  ');

%>



global direct_global_var

def output(name):

	direct_global_var = 'planet earth, (mercury, venus) mars, etc'
	direct_local_var = 'hello world'
	local_var2 = 'hows it going'
	int_var = 1223344
	float_var = 5566778899.0	
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
<body><br>

%> + <% 'hello world<br> what is around there' %>.htmlentities() +

<%
 {**{direct_local_var}**}  {**{local_var2}**}  {**{direct_global_var}**} {**{int_var}**} {**{float_var}**}
<br>

<a href="{**{pagesourcelink}**}">click to view pyThor page source</a> <br>  
<pre style="display:inline">{**{pagesource}**}</pre>
<!-- similar to view source as feature of web browsers -->  

<a href="{**{fullsourcelink}**}">view full page source</a> <br>
<pre style="display:inline">{**{fullsource}**}</pre>

<a href="{**{pythorinfolink}**}">pyThorInfo</a> {**{pyThorinfo}**}  
<!-- Display pyThor environment by a url get (variable) -->

<br>{**{testing_output}**}<br>
<div id="container">

<div id="top">{**{top_content_var}**}</div>

<div id="mid">{**{mid_content_var}**}  <br>  <pre>{**{features}**}</pre>   </div>

<div id="end">{**{end_content_var}**}</div>

</div>

NOTE: Just Testing OUTPUT HERE (note: the following escape characters need double backslash (octals not tested at this time)<br>
\\\r\\n\\t\\0\\x0B  testing1, expected
<br>
\\a\\1\\2\\3\\4\\5\\6\\7\\8\\9\\b\\f\\v\\r\\n\\t\\0\\x0B   testing2, expected
Result: Easy dealing with escape characters here. Though a python def, function like PHP's htmlentities still perhaps required (to be written,created)
<br>
PHP test: {**{php_test}**}
</body>
</html>


<unicode>hello world</unicode>


<pre style="white-space: pre-wrap;"> (note that this wrap use of pre tags will wrap its text)

<b>Any Characters permissible within python quick tags &lt;% %&gt; (strings), neat</b>

Though this to note:<br>
&lt;% %&gt; , allows quick tags between quick tags though must be in html entities form


''' triple single quotes allowed also '''

""" triple double quotes now allowed within python quick tags, feature added 2015.02.08 """

</pre>

<h1>Example Of Displaying Source Code</h1>
<pre>{**{source_variable}**}</pre>    (Note that to display source code with the same newlines as in the source code, it should be wrapped in pre tags without the css style wrapping of text as in the examples before and after the display of this source code)


<pre style="white-space: pre-wrap;">
This format variable (see your_page.) is processed, it's converted to htmlentities
feature added to QuickTags to htmlentities any python quick tags &lt;% %&gt; (string) (Note: only python quick tag &lt;% %&gt; strings MUST be converted, the rest optional for display purposes), feature added 2015.02.17


(Note: To not .htmlentities the contents of the page itself within the &lt;head&gt;&lt;/head&gt; section of html tags, javascript between python quick tags &lt;% %&gt; , etc. ) 

(htmlentities can be used for many purposes, such as to display source code blocks of code)

quick way to html entities a string {**{example_htmlentities_string}**}

While still compatible with being able to use python format variables,

{**{ python quick tags format variable now as wysiwyg text when undefined in format method parameters, feature added 2015.02.16 }**}


{**{     var    }**}
</pre>

</pre>

%>.format (  # variables used

	top_content_var = top_content(),
	mid_content_var = mid_content(),
	end_content_var = end_content(),
	php_test    = php(code),  # just testing, remove if coding anything serious
	
	domain = 'us' if (name == 'A') else  'com',                  # else (name == 'WIDE')  # or something like whether a mobile device, resolution information, etc. to select which css that fits

	testing_output = '', #this_is_a_test(),    # test of include file using quick tags python syntax

	source_variable = source_code(),

	example_htmlentities_string = <%  <p><hello world note p tags output><p>  %>.htmlentities(), # note, python quick tags stings have .htmlentities method

	pagesourcelink = os.path.basename(__file__).replace('_compiled.py', '.php')+'?pagesource',  # php filename witout extension

	pagesource = source_code_from_file( os.path.basename(__file__).replace('_compiled.py', '.py') ) if (QUERY_STRING == 'pagesource') else '' , 								 			 
	
	fullsourcelink = os.path.basename(__file__).replace('_compiled.py', '.php')+'?fullsource' ,     # its auto calculated based on the page name,  or just code   'pytron_nice_page_name.php?fullsource'    #though would have to be edited with each page name change

	fullsource = get_fullsource(comments = True, pretags=True) if (QUERY_STRING == 'fullsource') else '' , 

	 __formatvariable_range = ('*--START OF FULL SOURCE--*'.replace(' ', '_' ) , '*--END OF FULL SOURCE--*'.replace(' ', '_' )) if (QUERY_STRING == 'fullsource') else ('',''),
	
	pythorinfolink = os.path.basename(__file__).replace('_compiled.py', '.php')+'?pythorinfo' ,     # or simply code 'pytron_nice_page_name.php?pythorinfo     #though again, would have to be edited with each page name change

	pyThorinfo = display_pythorinfo()  if (QUERY_STRING == 'pythorinfo') else '',   #remove this line to remove the url feature  	# for demonstration purpose only, please remove the next line for production code (it is however a feature that is available at any time should you code it)

	features = display_features() if (QUERY_STRING == 'features') else ''
)

	# testing writing print statement to the web browser 
	# the intent is to create a python function to wrap the writing with print statements to the web browser's console
	code_init = <%
$name = 'Stan Switaj';
 
$fruits = array("banana", "apple", "strawberry", "pineaple");
 
$user = new stdClass;
$user->name = 'Hello 123.00 \\a\\1\\2\\3\\4\\5\\6\\7\\8\\9\\b\\f\\v\\r\\n\\t\\0\\x0B ';
$user->desig = "CEO";
$user->lang = "PHP Running Through subprocess (python)";
$user->purpose = "To print log messages to the browser console messages to the browser";
// var_dump($fruits);        // Remove php comment to output data structure to web browser 
logConsole('$name var', $name, true);
logConsole('An array of fruits', $fruits, true);
logConsole('$user object', $user, true);
%>

	# Written to print to the console log of a web browser
	s = (code_init + "\n" + console_log_function()  )
	
	# For convenience I've included it in the following write statement anyway (to get the exact equivalent to the PHP source code string)
	# The next line is optional to the OUTPUT to Web (i.e., it will not affect the display OUTPUT to web 
	# It's just to inspect and review the string by writing it to a file)
	s = s.replace("#\\'#", "#'#").replace('#\\"\\"#', '#""#').replace("#\\'\\'#", "#''#") # comment this line out to view the exact string that gets OUTPUT to the web
	
	# TO OUTPUT to web
	print php(  s   )

	
#   notes:
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
import os

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
	
	
def concat2( itemA, itemB, new, s):
	
	return re.sub( itemB + r'\s{0,}\+\s{0,}<%', new, s )

	
def algorithm(s, uni_val=str(True) ):
	
	global option_auto_trailing_backslash_doubleit # when set to False adds space to resolve trailing backslash issue
	
	uni_str = '.unicode_markup('+uni_val+')'
	
	
	s = s.replace('return <%', 'return pyQuickTags(r"""')
	s = s.replace('= <%', '= pyQuickTags(r"""')
	
	# note adjacent function for any number of spaces between ( and <%
	s = adjacent('(', '<%', '( pyQuickTags(r"""', s)
	
	s = concat2( '+', '%>', '%> + pyQuickTags(r"""', s)
	
	s = concat2( '+', "\)",  ') + pyQuickTags(r"""', s)
	
	s = concat2( '+', "\'", '\' + pyQuickTags(r"""', s)  # when text in form  ' + %> or " + %> required
	s = concat2( '+', '\"', '\" + pyQuickTags(r"""', s)  # can comment these two lines out then
	
	s = s.replace('<%', 'print pyQuickTags(r"""')
#		s = s.replace('%%>', ')'+uni_str )    # UNCOMMENT POINT *C* (uncomment the FIRST comment hash tag for the remove unicode operation)      # to remove quick workaround, remove this line
	
	if(option_auto_trailing_backslash_doubleit): # an alternative to the algorithm2 solution that (resolves it by adding a trailing backslash) is 
		s = s.replace('%>','""").initsupers(locals(),globals())')              # to simply add a space to the end of the string at this exact point of the code (that modifies the compiled code only) that somewhat resolves the trailing backslash issue in python triple double quotes 2015.02.08
	else:
		s = s.replace('%>',' """).initsupers(locals(),globals())')     # adds a space 

#		s = s.replace('""")).format (     %:)>', '""").format (   #  %:)> ')    # UNCOMMENT POINT *D* (uncomment the FIRST comment hash tag for the remove unicode operation)     
	# about the previous line,  to remove quick workaround, remove this line, way to rid one close parenthesis, with the happy face keyword created for this purpose , it comments out the keyword %:)> 

	# statements marked by UNCOMMENT POINT *C* and *D* uncomment to remove unicode type quick python tags
	# uncomment to remove unicode type quick python tags i.e., <unicode> </unicode>  though the contents in between the tags remain intact
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

	
def get_string_tag_to_tag_read_source(file, start_tag, end_tag):  # same function to get_string_tag_to_tag the PHP version I wrote
	
	s=''
	with open( file, 'r' ) as fp:  #file pointer (of features file 
		s = fp.read()
	
	start = s.find(start_tag)
	
	if (start == -1):
		print 'early exit, could not find start_tag ' + start_tag + ' in file: ' + features_file + '<br>' 
		sys.exit(1)
		
	end = s.find(end_tag)
	
	if (end == -1):
		print 'early exit, could not find end_tag' + end_tag + ' in file: ' + features_file + '<br>'
	
	return s[start+len(start_tag):end]	#  +1 perhaps
	
def modify_diff(type_val, source, destination, uni_val=''):

	global option_auto_trailing_backslash_doubleit
	
	# assemble point the source file (within same file)
	
	# tag to tag read of main features, then read of source, then read of tag to tag of main,argument part
	
	features_file = 'simple_preprocessor_pyThor_features_txt.py'
	
	print 'source=' + source + '<br>'
	if exists(source):	
		print 'source DOES exist' + '<br>'
	else:
		print 'source does NOT exist' + '<br>'
		
	print 'current file=' + __file__ + '<br>'
	cwd_path = os.path.dirname(__file__) + '<br>'
	print 'cwd=' + cwd_path + '<br>'
	
	features_file = os.path.dirname(__file__) + '/' + features_file

	if exists(features_file):	
		print 'features_file DOES exist' + '<br>'
	else:
		print 'features_files does NOT exist' + '<br>'


	opentag   = '#_PYTHON_QUICK_TAGS_FEATURES_OPEN_TAG_#'
	closetag  = '#_PYTHON_QUICK_TAGS_FEATURES_CLOSE_TAG_#'
	features  = get_string_tag_to_tag_read_source( features_file, opentag, closetag )
	
	
	opentag   = '#_MAIN_PROGRAM_OPEN_TAG_#'
	closetag  = '#_MAIN_PROGRAM_CLOSE_TAG_#'
	mainintro = get_string_tag_to_tag_read_source( features_file, opentag, closetag )
	

	with open(source, 'r') as rp:
		s = rp.read()
	
	if (type_val == '-M'):	#otherwise its -I
		s = features + s + mainintro

	#print 'Length:' + str(len(s)) + '<br>'
	#print s	
	#print 'early exit'
	#sys.exit(1)

	if (option_auto_trailing_backslash_doubleit): # by converting trailing \ to \\   Otherwise alternative method to add space, i.e., set this variable to False at the top
		s = algorithm2(s)
	
	
	s = algorithm_to_allow_tdq_within_quick_tags(s) # python quick tags are already the initial tags
		
	#s = algorithm_to_allow_tdq_within_quick_tags_final_done(s, '<%', '%>', '"""', '&quot;&quot;&quot;') # instead of regex

	with open(destination, 'w') as wp:
			wp.write( algorithm(s, uni_val) )


def exists(path):	# file_exists
	if (os.path.isfile(path)):
		return path
	else:
		print 'file does not exist, early exit' + path + '<br>'
		sys.exit(1)

def type_check(type):
	if ( type == '-I' or type == '-M' ):
		return type
	else:
		print 'first argument required is -M or -I ,early exit'+'<br>'
		sys.exit(1)

if __name__ == "__main__":  # in the case not transferring data from php, then simply revert to a previous version, commit
	# simply remove or comment out the print statements at your convenience, used just for debugging and testing purposes
	if( not len(sys.argv) >= 2 ):
		print "argument is required, which domain name from the initial, starting PHP"
		sys.exit(1)
	
	print (' Preprocessor ')
	print_args(sys.argv)
	
	type   =''
	unicode=''
	count  = len(sys.argv)

	if( count == 3):
		src  = exists(sys.argv[1])
		dst  = sys.argv[2]
	if( count == 4):
		type = type_check(sys.argv[1])
		src  = exists(sys.argv[2])
		dst  = sys.argv[3]
	if( count  == 5):
		type    = type_check(sys.argv[1])
		src     = exists(sys.argv[2])
		dst     = sys.argv[3]
		unicode = sys.argv[4]
		
	modify_diff( type_val=type, source=src, destination=dst, uni_val=unicode )



# END PRE PROCESSOR.PY WRITE OUTPUT #
### NOTE: DO NOT CHANGE THE TEXT ON THE PREVIOUS LINE!!!!		
		
		
		
		
### NOTE: DO NOT CHANGE THE TEXT ON THE NEXT LINE!!!!
# START PRE PYTHOR FEATURES.PY WRITE OUTPUT #






# NOTE: this does NOT compile, it is to be the features of PyThor that the simple_preprocesor 'links' to your PyThor program



# DO NOT EDIT THE TEXT ON THE FOLLOWING LINE, used to automatically generate _compiled.py source code #
#_PYTHON_QUICK_TAGS_FEATURES_OPEN_TAG_#




import os
import sys
from subprocess import PIPE, Popen, STDOUT
import time
import ast
import uuid
import json


global pyGET
global pyPOST
global pySERVER
global pyFILES

global PREPROCESSOR_FOLDER
global SOURCE_FOLDER

global ensure							   # set to True initially, for a slight speed increase set to False, This is a variable name check of PHP to pyThor superglobal variables
ensure = True							   # this is to verify that the variable from the PHP superglobal variable are the variables by their name (string comparison)
										   #
										   # when an update to a new PHP version occurs, 
										   # any new variable (from a PHP upgrade) to pyThor (i.e., not a convenience variable yet) 
										   # then be sure to use the function   exists('' , pySERVER)  when accessing it each time  (this guarentees it is there)

global warn_when_new_php_variables
warn_when_new_php_variables = True         # when an update to a new PHP version occurs, this will warn that a convenience varible does not exist for it, 
                                           # note that this is just a warning and can be turned off (set to False) and that this variable will ALWAYS (in any case) be available from the pySERVER variable (though Note: when it is a new variable be sure to check that it exists in pySERVER with the exists( 'var', pySERVER) function (due to convenience variable not initializing it if its not there (internal: i.e., sent over from php every time) ) 
										   # (if warnings do occur, i.e., a new variable occurs from a PHP upgrade, an upgrade to latest pyThor version is recommended (or if not upgrading pyThor at this time)
										   # then accessing the new variable from pySERVER superglobal variable is fine too)
										   
pyGET={};pyPOST={};pySERVER={};pyFILES={}  # main superglobal variables (accessible similar to how they are from PHP source code)


# Apache Environment ( each variable within pySERVER the "PHP Variables" from PHP $_SERVER ) # available for use
# for the variables, e.g., DOCUMENT_ROOT
# (these are) convenience variables
global HTTP_HOST;global HTTP_USER_AGENT;global HTTP_ACCEPT;global HTTP_ACCEPT_LANGUAGE;global HTTP_ACCEPT_ENCODING;
global HTTP_CONNECTION;global PATH;global SystemRoot;global COMSPEC;global PATHEXT;global WINDIR;global SERVER_SIGNATURE;
global SERVER_SOFTWARE;global SERVER_NAME;
global SERVER_ADDR;global SERVER_PORT;global REMOTE_ADDR;global DOCUMENT_ROOT;global REQUEST_SCHEME;global CONTEXT_PREFIX;
global CONTEXT_DOCUMENT_ROOT;global SERVER_ADMIN;global SCRIPT_FILENAME;global REMOTE_PORT;global GATEWAY_INTERFACE;
global SERVER_PROTOCOL;global REQUEST_METHOD;global QUERY_STRING;global REQUEST_URI;global SCRIPT_NAME;global PHP_SELF;
global REQUEST_TIME_FLOAT;global REQUEST_TIME;

# temperamental variables ( sometimes received,  though ALWAYS initialized )
global HTTP_CACHE_CONTROL;global HTTP_REFERER;global HTTP_PRAGMA;global HTTP_DNT;global HTTP_COOKIE;


# These variables are automatically populated by the create_superglobals function, please do NOT edit them!
# Note that these variable are available for use throughout your website source code (program), Enjoy!
HTTP_HOST='';HTTP_USER_AGENT='';HTTP_ACCEPT='';HTTP_ACCEPT_LANGUAGE='';HTTP_ACCEPT_ENCODING='';
HTTP_CONNECTION='';PATH='';SystemRoot='';COMSPEC='';PATHEXT='';WINDIR='';SERVER_SIGNATURE='';
SERVER_SOFTWARE='';SERVER_NAME='';
SERVER_ADDR='';SERVER_PORT='';REMOTE_ADDR='';DOCUMENT_ROOT='';REQUEST_SCHEME='';CONTEXT_PREFIX='';
CONTEXT_DOCUMENT_ROOT='';SERVER_ADMIN='';SCRIPT_FILENAME='';REMOTE_PORT='';GATEWAY_INTERFACE='';
SERVER_PROTOCOL='';REQUEST_METHOD='';QUERY_STRING='';REQUEST_URI='';SCRIPT_NAME='';PHP_SELF='';
REQUEST_TIME_FLOAT='';REQUEST_TIME='';
HTTP_CACHE_CONTROL='';HTTP_REFERER='';HTTP_PRAGMA='';HTTP_DNT='';HTTP_COOKIE='';


def findtags(open, close, s):
	t=[] #list,array,vector...
	idx=0
	item =''
	while(idx != -1):
	
		idx = s.find(open, idx)
		if idx == -1:
			break;
			
		idx2 = s.find(close, idx+1)
		if idx2 == -1:
			break;
			
		item = s[idx+len(open):idx2]
		t.append(item) # potential variable name
		idx += 1
		item ='' # reset item
		
	return t

def make_tuples(s):		# for direct format variables using python quick tags {**{  }**}

	fv = []

	start = 0
	pos   = 0  # or idx

	while (1):

		pos = s.find( '{**{', pos )

		if (pos == -1):
			break
		else:
			pos += 4
			start = pos
			pos = s.find( '}**}', pos )
			fv.append( s[start:pos]  )  # (start, pos)
			pos += 4
			
	return fv		
	
	
class utags(str): # just an idea
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
		
		return     str( self ).format(*args, **kwargs)  # note:  .format method converts  {{ to {
			
			
class pyQuickTags(str):
	
	str_fv = Str_fv()
	
	def __init__(self, v):        # optional
		self.str_fv = Str_fv(v)
	
	
	def format(self, *args, **kwargs):
		
		opentag=''
		closetag=''
		if '__formatvariable_stop' in kwargs:  # note: opentag not used 
			closetag = kwargs.get('__formatvariable_stop')
		
		if '__formatvariable_range' in kwargs:
			tuple = kwargs.get('__formatvariable_range')		
			opentag  = tuple[0]
			closetag = tuple[1]

		return pyQuickTags( self.str_fv.format(*args, **kwargs) ).fullsource_truncate(startfullsource_substring = opentag, endfullsource_substring = closetag)   # or init  str_fv()  at this point
	
	
	def fullsource_truncate(self, startfullsource_substring, endfullsource_substring):
		
		startpos = self.find(startfullsource_substring)
		
		endpos = self.find(endfullsource_substring) # already found (or to end of string)

		if (startfullsource_substring == ''):	    # NOT the same as     startpos == -1
			startpos = 0
		
		msg=''
		if (endfullsource_substring   == ''):       # NOT the same as       endpos == -1
			endpos = len(self)
		else:
			msg = '<br>Full Source Code Display Done. <br>NOTE: early exit from a truncate of an end of full source substring<br><br>'
		

		return pyQuickTags(self[startpos+len(startfullsource_substring):endpos]   +  msg  )  # update: fix 03-03-2015  parenthesis required outside the string, otherwise htmlentities and additional pyQuickTag methods are not available due to a conversion to a str string from a pyQuickTags string
																			   #.to_file('justtosee.txt')  # I append this to the pyQuickTags at that point, (one line up) to then view what the data is at that point

	def initsupers(self, *args):
		
		format_vars = make_tuples(self)

		for item in format_vars:

			data = args[0].get(item)  # locals
			if type(data) is str and data:
				self = self.replace( '{**{'+item+'}**}' , data )
			elif data is None:
				pass
			elif type(data) is int:
				self = self.replace( '{**{'+item+'}**}' , str(data) )
			elif type(data) is float:
				self = self.replace( '{**{'+item+'}**}' , str(data) )
			elif type(data) is long:
				self = self.replace( '{**{'+item+'}**}' , str(data) )
	
			data = args[1].get(item)  # globals
			if type(data) is str and data:
				self = self.replace( '{**{'+item+'}**}' , data )
			elif data is None:
				pass
			elif type(data) is not int and type(data) is not float and type(data) is not long:     # filtered due to a function type
				self = self.replace( '{**{'+item+'}**}' , str(data) )

		return pyQuickTags(self)		
		
	def htmlentities(self):
	
		salt = uuid.uuid4().hex
		s = self.replace('&quot;&quot;&quot;', '*QUOT-*-QUOT-*-QUOT*'+salt)
		s = s.replace("'",  '*apos-*'+salt)
		s = s.replace(r'\\', '*slash-*'+salt)
		
		code_init = <% echo htmlentities('%s'); %>  %  s   # or r"""   """
		var = php(code_init)

		var = var.replace('*QUOT-*-QUOT-*-QUOT*'+salt, '&quot;&quot;&quot;')		
		var = var.replace( '*apos-*'+salt,  "'")
		var = var.replace( '*slash-*'+salt, r'\\')
		
		var = var.replace( '&amp;lt;%' , '&lt;%' ).replace( '%&amp;gt;', '%&gt;' ) # perhaps salt quick tags too
		
		return pyQuickTags(var)		#return var # this ok, perhaps to wrap return with QuickTags() to then allow another method call
		

	def encodehex(self):
		return pyQuickTags( str(self).encode('hex') )

	def encode(self, how): # or  *args, **kwargs
		return pyQuickTags( str(self).encode(how) ) # i,e., 'hex'
			
			
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

<script>
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

</script>

JSCODE;
        echo $js;
     } # end logConsole
%>		


# compiler functions
def mod_dt(file):
	return time.strftime("%Y%m%d%H%M%S",time.localtime(os.path.getmtime(file)));

							   # dual-purpose naming of a function is not recommended		e.g., (  distinct function names,  kexists (for key exists) or key_exists() , fexists (for file or folder exists) or filefolder_exists(), etc.  )
def exists(arg1, object=''):   # an interesting function   2 argument defines this as a key check to an object (primary) , purpose
							   #
							   #                           1 argument it is a file or folder exists check      (secondary) (distinct based on variable count, therefore no implicit variables in this function)

	if (object == ''): # therefore 1 argument
		return True if ( os.path.isfile(arg1) or os.path.isdir(arg1)) else False   # arg1 is a path (of a file or folder path)
	
	else:              # therefore 2 arguments, this is the key check to an object (e.g., new variable nam contained in pySERVER check)
		if arg1 in object:
			#    when_true                   when_false
			return True if arg1 in object else False
			#
			# if arg1 in object:
			#	return True
			# else:
			#	return False
	
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

	compiled = file[:-3] + '_compiled.py'
	
	if ( is_compiled(file, compiled) ):
		#print '(INCLUDE ALREADY COMPILED)'
		return compiled
	
	print '(INCLUDE NOT compiled yet, therefore COMPILING)'
	
	os.system('"python.exe simple_preprocessor.py -I '+file+' '+compiled+' 2>&1"')
	
	print( 'INCLUDING THIS FILE(' + compiled + ')' )
	return compiled # run pre_processor on it, with file being the source and  it as the dest
		
	# any includes done here to evaluate one file format variable, Q. can I include in a def,function
	
	
def include_quick_tags_file(source):

	print( 'POINT #1 file is:('+ source + ')' )
	f = os.path.abspath(compile_include_quick_tags(source)) # compiled variable
	print( '<br>file to include('+f+')' )
	
	return f
	

def print_wwwlog(s):    # prints to brower's console log
	
	s = s.encode('hex')              
	s = '<hex>'+s+'</hex>'           
		
	code_init = <%
$name1 = '{**{s}**}';
logConsole('$name1 var', $name1, true);
%>
	wwwout = code_init + "\n" + console_log_function()
	print php(  wwwout  ) # to web


def php(code): # shell execute PHP from python (that is being called from php5_module in Apache), for fun...
	p = Popen(['php'], stdout=PIPE, stdin=PIPE, stderr=STDOUT) # open process
	o = p.communicate('PHP_OPEN_TAG_REPLACE ' + code )[0]      # updated, removing closing tag, solution 02-21-2015
	try:
		os.kill(p.pid, signal.SIGTERM)	# kill process
	except:
		pass
	return o	

	
def source_code_from_file(file):
	
	source=''   # note: can r' ' string a full path to enter a string as text as string literals due to special characters, i.e., the backslash https://docs.python.org/2/reference/lexical_analysis.html#string-literals
	with open(file, 'r') as fp:   # or .cpp .php  etc.
		source = fp.read()
		source = source.replace('"""', '&quot;&quot;&quot;')            # note: added 02-20-2015

	return <%

{**{source}**}

%>.htmlentities()


def exit_program(var):
	print 'early exit, ensure verified, variable name different, at the variable: ' + var + '<br>'
	sys.exit(1)


def superglobal_preprocessor_folder(args):
	global PREPROCESSOR_FOLDER
	PREPROCESSOR_FOLDER = sys.argv[6]

def superglobal_source_folder(args):
	global SOURCE_FOLDER
	SOURCE_FOLDER = sys.argv[7]
	
def read_superglobalvariable_file(file):
	
	with open(file, 'r') as fp:
		arr = fp.read().splitlines()
		#arr[1] = '' if (arr[1]=='[]') else arr[1] #sanitizes, otherwise additional or to a function...
		#arr[2] = '' if (arr[2]=='[]') else arr[2] #...
		#arr[3] = '' if (arr[3]=='[]') else arr[3] #...		
	return ( arr[0], arr[1], arr[2], arr[3] )

	
def to_str(s): # from '' or []
	return '' if ( s == '[]' ) else s
	
def create_superglobals(args):
	
	global pySERVER  # only to edit, readonly is accessible
	global pyGET
	global pyPOST
	global pyFILES

	superglobal_preprocessor_folder(args)
	superglobal_source_folder(args)
	
	if sys.argv[2] == 'file': # i.e., > 8000 in length ( workaround dos prompt limit via passthru )
	
		print 'file mode workaround' + '<br>'    # perhaps virtual in-memory file solution (to this) 
		
		file = sys.argv[3]
		print 'file received is: ' + file + '\n'
		arr = read_superglobalvariable_file(file)

		print 'arr0:'+ arr[0] + '<br>'     # pySERVER
		print 'arr1:'+ arr[1] + '<br>'     # pyGET
		print 'arr2:'+ arr[2] + '<br>'     # pyPOST
		print 'arr3:'+ arr[3] + '<br>'     # pyFILES
		
		data     = json.loads( arr[0] )  # from a file, first line         # could directly load to pySERVER
		pyGET    = json.loads( arr[1] ) if not(to_str(arr[1])=='') else {} # in case its an empty string       (   previous code:  # if arr[1]=='' else {}      )
		pyPOST   = json.loads( arr[2] ) if not(to_str(arr[2])=='') else {}
		pyFILES  = json.loads( arr[3] ) if not(to_str(arr[3])=='') else {}
	
	else:
                                         # from dos prompt args sequence (received as string type)
		data     = json.loads( sys.argv[2].decode('hex') ) # could directly load to pySERVER (but going to ensure both pySERVER contents and convenience variables same data (and also verify that at minimum are presumed to exist) )
		pyGET    = json.loads( sys.argv[3].decode('hex') ) if not(to_str(sys.argv[3].decode('hex'))=='') else {} # when received as   5b5d  (its hex version of an empty string)  , empty string '' converted then to a {}
		pyPOST   = json.loads( sys.argv[4].decode('hex') ) if not(to_str(sys.argv[4].decode('hex'))=='') else {} # when received as   5b5d  (its hex version of an empty string)  , empty string '' converted then to a {}
		pyFILES  = json.loads( sys.argv[5].decode('hex') ) if not(to_str(sys.argv[5].decode('hex'))=='') else {} # when received as   5b5d  (its hex version of an empty string)  , empty string '' converted then to a {}
		
	##### e.g.,   global QUERY_STRING  only to edit, readonly is accessible (works different in PHP)
	
	global warn_when_new_php_variables
	
	#json encoded order
	global REQUEST_TIME;       global CONTEXT_DOCUMENT_ROOT; global SERVER_SOFTWARE;  
	global CONTEXT_PREFIX;     global SERVER_SIGNATURE;      global REQUEST_METHOD;
	global SystemRoot;         global QUERY_STRING;          global PATH;
	global HTTP_USER_AGENT;    global HTTP_CONNECTION;       global PHP_SELF;        global SERVER_NAME;
	global REMOTE_ADDR;        global SERVER_PROTOCOL;       global SERVER_PORT;     global SERVER_ADDR;
	global DOCUMENT_ROOT;      global COMSPEC;               global SCRIPT_FILENAME; global SERVER_ADMIN;
	global HTTP_HOST;          global SCRIPT_NAME;           global PATHEXT;         global REQUEST_URI;
	global HTTP_ACCEPT;        global WINDIR;                global GATEWAY_INTERFACE;
	global REMOTE_PORT;        global HTTP_ACCEPT_LANGUAGE;  global REQUEST_SCHEME;
	global REQUEST_TIME_FLOAT; global HTTP_ACCEPT_ENCODING;
	global HTTP_CACHE_CONTROL; global HTTP_REFERER;          global HTTP_PRAGMA;
	global HTTP_DNT;           global HTTP_COOKIE;
	

	for var_name, item in data.items(): # to populate the data structure, dict
		pySERVER[var_name] = item
		

	# this is to assign the variable names to indices, to do unable at this time to assign string variable names to the variables directly
	# therefore, this is the purpose for the   ensure   variable
	server_variables = { 	
'REQUEST_TIME':0, 'CONTEXT_DOCUMENT_ROOT':1,'SERVER_SOFTWARE':2, 'CONTEXT_PREFIX':3, 'SERVER_SIGNATURE':4,
'REQUEST_METHOD':5,'SystemRoot':6,'QUERY_STRING':7,'PATH':8,'HTTP_USER_AGENT':9,'HTTP_CONNECTION':10,
'PHP_SELF':11,'SERVER_NAME':12,'REMOTE_ADDR':13,'SERVER_PROTOCOL':14,'SERVER_PORT':15,'SERVER_ADDR':16,
'DOCUMENT_ROOT':17,'COMSPEC':18,'SCRIPT_FILENAME':19,'SERVER_ADMIN':20,'HTTP_HOST':21,'SCRIPT_NAME':22,
'PATHEXT':23,'HTTP_CACHE_CONTROL':24,'REQUEST_URI':25,'HTTP_ACCEPT':26,'WINDIR':27,'GATEWAY_INTERFACE':28,
'REMOTE_PORT':29,'HTTP_ACCEPT_LANGUAGE':30,'REQUEST_SCHEME':31,'REQUEST_TIME_FLOAT':32,'HTTP_ACCEPT_ENCODING':33,
'HTTP_REFERER':34,'HTTP_PRAGMA':35,'HTTP_DNT':36,'HTTP_COOKIE':37
}


	for var_name, item in data.items():

		if var_name in server_variables:
			x = server_variables[var_name]
		else:
			if (warn_when_new_php_variables):
				print '<br>WARNING: Note that this variable is accessible through the pySERVER superglobal variable only at this time('+var_name+')' +'<br>'
			continue
			
		if (ensure):
		
			if   (x == 0):
				REQUEST_TIME         = item if (var_name == 'REQUEST_TIME' )         else exit_program('REQUEST_TIME')
			elif (x == 1):
				CONTEXT_DOCUMENT_ROOT = item if (var_name == 'CONTEXT_DOCUMENT_ROOT') else exit_program('CONTEXT_DOCUMENT_ROOT')
			elif (x == 2):
				SERVER_SOFTWARE      = item if (var_name == 'SERVER_SOFTWARE' )      else exit_program('SERVER_SOFTWARE')
			elif (x == 3):
				CONTEXT_PREFIX       = item if (var_name == 'CONTEXT_PREFIX' )       else exit_program('CONTEXT_PREFIX')
			elif (x == 4):
				SERVER_SIGNATURE     = item if (var_name == 'SERVER_SIGNATURE' )     else exit_program('SERVER_SIGNATURE')
			elif (x == 5):
				REQUEST_METHOD       = item if (var_name == 'REQUEST_METHOD' )       else exit_program('REQUEST_METHOD')
			elif (x == 6):
				SystemRoot           = item if (var_name == 'SystemRoot' )           else exit_program('SystemRoot')
			elif (x == 7):
				QUERY_STRING         = item if (var_name == 'QUERY_STRING' )         else exit_program('QUERY_STRING')
			elif (x == 8):
				PATH                 = item if (var_name == 'PATH' )                 else exit_program('PATH')
			elif (x == 9):
				HTTP_USER_AGENT      = item if (var_name == 'HTTP_USER_AGENT' )      else exit_program('HTTP_USER_AGENT')
			elif (x == 10):
				HTTP_CONNECTION      = item if (var_name == 'HTTP_CONNECTION' )      else exit_program('HTTP_CONNECTION')
			elif (x == 11):
				PHP_SELF             = item if (var_name == 'PHP_SELF' )             else exit_program('PHP_SELF')
			elif (x == 12):
				SERVER_NAME          = item if (var_name == 'SERVER_NAME' )          else exit_program('SERVER_NAME')
			elif (x == 13):
				REMOTE_ADDR          = item if (var_name == 'REMOTE_ADDR' )          else exit_program('REMOTE_ADDR')
			elif (x == 14):
				SERVER_PROTOCOL      = item if (var_name == 'SERVER_PROTOCOL' )      else exit_program('SERVER_PROTOCOL')
			elif (x == 15):
				SERVER_PORT          = item if (var_name == 'SERVER_PORT' )          else exit_program('SERVER_PORT')
			elif (x == 16):
				SERVER_ADDR          = item if (var_name == 'SERVER_ADDR' )          else exit_program('SERVER_ADDR')
			elif (x == 17):
				DOCUMENT_ROOT        = item if (var_name == 'DOCUMENT_ROOT' )        else exit_program('DOCUMENT_ROOT')
			elif (x == 18):
				COMSPEC              = item if (var_name == 'COMSPEC' )              else exit_program('COMSPEC')
			elif (x == 19):
				SCRIPT_FILENAME      = item if (var_name == 'SCRIPT_FILENAME' )      else exit_program('SCRIPT_FILENAME')
			elif (x == 20):
				SERVER_ADMIN         = item if (var_name == 'SERVER_ADMIN' )         else exit_program('SERVER_ADMIN')
			elif (x == 21):
				HTTP_HOST            = item if (var_name == 'HTTP_HOST' )            else exit_program('HTTP_HOST')
			elif (x == 22):
				SCRIPT_NAME          = item if (var_name == 'SCRIPT_NAME' )          else exit_program('SCRIPT_NAME')
			elif (x == 23):
				PATHEXT              = item if (var_name == 'PATHEXT' )              else exit_program('PATHEXT')
			elif (x == 24):
				HTTP_CACHE_CONTROL   = item if (var_name == 'HTTP_CACHE_CONTROL' )   else exit_program('HTTP_CACHE_CONTROL')
			elif (x == 25):
				REQUEST_URI          = item if (var_name == 'REQUEST_URI' )          else exit_program('REQUEST_URI')
			elif (x == 26):
				HTTP_ACCEPT          = item if (var_name == 'HTTP_ACCEPT' )          else exit_program('HTTP_ACCEPT')
			elif (x == 27):
				WINDIR               = item if (var_name == 'WINDIR' )               else exit_program('WINDIR')
			elif (x == 28):
				GATEWAY_INTERFACE    = item if (var_name == 'GATEWAY_INTERFACE' )    else exit_program('GATEWAY_INTERFACE')
			elif (x == 29):
				REMOTE_PORT          = item if (var_name == 'REMOTE_PORT' )          else exit_program('REMOTE_PORT')
			elif (x == 30):
				HTTP_ACCEPT_LANGUAGE = item if (var_name == 'HTTP_ACCEPT_LANGUAGE' ) else exit_program('HTTP_ACCEPT_LANGUAGE')
			elif (x == 31):
				REQUEST_SCHEME       = item if (var_name == 'REQUEST_SCHEME' )       else exit_program('REQUEST_SCHEME')
			elif (x == 32):
				REQUEST_TIME_FLOAT   = item if (var_name == 'REQUEST_TIME_FLOAT' )   else exit_program('REQUEST_TIME_FLOAT')
			elif (x == 33):
				HTTP_ACCEPT_ENCODING = item if (var_name == 'HTTP_ACCEPT_ENCODING' ) else exit_program('HTTP_ACCEPT_ENCODING')
			elif (x == 34):
				HTTP_REFERER         = item if (var_name == 'HTTP_REFERER' )         else exit_program('HTTP_REFERER')
			elif (x == 35):
				HTTP_PRAGMA          = item if (var_name == 'HTTP_PRAGMA' )          else exit_program('HTTP_PRAGMA')
			elif (x == 36):
				HTTP_DNT             = item if (var_name == 'HTTP_DNT'    )          else exit_program('HTTP_DNT')
			elif (x == 37):
				HTTP_COOKIE          = item if (var_name == 'HTTP_COOKIE' )          else exit_program('HTTP_COOKIE')
		else:
			if   (x == 0):
				REQUEST_TIME         = item
			elif (x == 1):
				CONTEXT_DOCUMENT_ROOT = item
			elif (x == 2):
				SERVER_SOFTWARE      = item 
			elif (x == 3):
				CONTEXT_PREFIX       = item 
			elif (x == 4):
				SERVER_SIGNATURE     = item 
			elif (x == 5):
				REQUEST_METHOD       = item 
			elif (x == 6):
				SystemRoot           = item 
			elif (x == 7):
				QUERY_STRING         = item 
			elif (x == 8):
				PATH                 = item 
			elif (x == 9):
				HTTP_USER_AGENT      = item 
			elif (x == 10):
				HTTP_CONNECTION      = item 
			elif (x == 11):
				PHP_SELF             = item 
			elif (x == 12):
				SERVER_NAME          = item 
			elif (x == 13):
				REMOTE_ADDR          = item 
			elif (x == 14):
				SERVER_PROTOCOL      = item 
			elif (x == 15):
				SERVER_PORT          = item 
			elif (x == 16):
				SERVER_ADDR          = item 
			elif (x == 17):
				DOCUMENT_ROOT        = item 
			elif (x == 18):
				COMSPEC              = item 
			elif (x == 19):
				SCRIPT_FILENAME      = item 
			elif (x == 20):
				SERVER_ADMIN         = item 
			elif (x == 21):
				HTTP_HOST            = item 
			elif (x == 22):
				SCRIPT_NAME          = item 
			elif (x == 23):
				PATHEXT              = item 
			elif (x == 24):
				HTTP_CACHE_CONTROL   = item 
			elif (x == 25):
				REQUEST_URI          = item 
			elif (x == 26):
				HTTP_ACCEPT          = item 
			elif (x == 27):
				WINDIR               = item 
			elif (x == 28):
				GATEWAY_INTERFACE    = item 
			elif (x == 29):
				REMOTE_PORT          = item 
			elif (x == 30):
				HTTP_ACCEPT_LANGUAGE = item 
			elif (x == 31):
				REQUEST_SCHEME       = item
			elif (x == 32):
				REQUEST_TIME_FLOAT   = item
			elif (x == 33):
				HTTP_ACCEPT_ENCODING = item
			elif (x == 34):
				HTTP_REFERER         = item
			elif (x == 35):
				HTTP_PRAGMA          = item
			elif (x == 36):
				HTTP_DNT             = item
			elif (x == 37):
				HTTP_COOKIE          = item
			
		if 'REQUEST_TIME' not in pySERVER.keys():
				REQUEST_TIME                 = ''
				pySERVER['REQUEST_TIME']     = ''
		if 'CONTEXT_DOCUMENT_ROOT' not in pySERVER.keys():
				CONTEXT_DOCUMENT_ROOT             = ''
				pySERVER['CONTEXT_DOCUMENT_ROOT'] = ''
		if 'SERVER_SOFTWARE' not in pySERVER.keys():
				SERVER_SOFTWARE              = ''
				pySERVER['SERVER_SOFTWARE']  = ''
		if 'CONTEXT_PREFIX' not in pySERVER.keys():
				CONTEXT_PREFIX               = ''
				pySERVER['CONTEXT_PREFIX']   = ''
		if 'SERVER_SIGNATURE' not in pySERVER.keys():
				SERVER_SIGNATURE             = ''
				pySERVER['SERVER_SIGNATURE'] = ''
		if 'REQUEST_METHOD' not in pySERVER.keys():
				REQUEST_METHOD               = ''
				pySERVER['REQUEST_METHOD']   = ''
		if 'SystemRoot' not in pySERVER.keys():
				SystemRoot                   = ''
				pySERVER['SystemRoot']       = ''
		if 'QUERY_STRING' not in pySERVER.keys():
				QUERY_STRING                 = ''
				pySERVER['QUERY_STRING']     = ''
		if 'PATH' not in pySERVER.keys():
				PATH                         = ''
				pySERVER['PATH']             = ''
		if 'HTTP_USER_AGENT' not in pySERVER.keys():
				HTTP_USER_AGENT              = ''
				pySERVER['HTTP_USER_AGENT']  = ''
		if 'HTTP_CONNECTION' not in pySERVER.keys():
				HTTP_CONNECTION              = ''
				pySERVER['HTTP_CONNECTION']  = ''
		if 'PHP_SELF' not in pySERVER.keys():
				PHP_SELF                     = ''
				pySERVER['PHP_SELF']         = ''
		if 'SERVER_NAME' not in pySERVER.keys():
				SERVER_NAME                  = ''
				pySERVER['SERVER_NAME']      = ''
		if 'REMOTE_ADDR' not in pySERVER.keys():
				REMOTE_ADDR                  = ''
				pySERVER['REMOTE_ADDR']      = ''
		if 'SERVER_PROTOCOL' not in pySERVER.keys():
				SERVER_PROTOCOL              = ''
				pySERVER['SERVER_PROTOCOL']  = ''
		if 'SERVER_PORT' not in pySERVER.keys():
				SERVER_PORT                  = ''
				pySERVER['SERVER_PORT']      = ''
		if 'SERVER_ADDR' not in pySERVER.keys():
				SERVER_ADDR                  = ''
				pySERVER['SERVER_ADDR']      = ''
		if 'DOCUMENT_ROOT' not in pySERVER.keys():
				DOCUMENT_ROOT                = ''
				pySERVER['DOCUMENT_ROOT']    = ''
		if 'COMSPEC' not in pySERVER.keys():
				COMSPEC                      = ''
				pySERVER['COMSPEC']          = ''
		if 'SCRIPT_FILENAME' not in pySERVER.keys():
				SCRIPT_FILENAME              = ''
				pySERVER['SCRIPT_FILENAME']  = ''
		if 'SERVER_ADMIN' not in pySERVER.keys():
				SERVER_ADMIN                 = ''
				pySERVER['SERVER_ADMIN']     = ''
		if 'HTTP_HOST' not in pySERVER.keys():
				HTTP_HOST                    = ''
				pySERVER['HTTP_HOST']        = ''
		if 'SCRIPT_NAME' not in pySERVER.keys():
				SCRIPT_NAME                  = ''
				pySERVER['SCRIPT_NAME']      = ''
		if 'PATHEXT' not in pySERVER.keys():
				PATHEXT                      = ''
				pySERVER['PATHEXT']          = ''
		if 'HTTP_CACHE_CONTROL' not in pySERVER.keys():
				HTTP_CACHE_CONTROL               = ''
				pySERVER['HTTP_CACHE_CONTROL']   = ''
		if 'REQUEST_URI' not in pySERVER.keys():
				REQUEST_URI                      = ''
				pySERVER['REQUEST_URI']          = ''
		if 'HTTP_ACCEPT' not in pySERVER.keys():
				HTTP_ACCEPT                      = ''
				pySERVER['HTTP_ACCEPT']          = ''
		if 'WINDIR' not in pySERVER.keys():
				WINDIR                           = ''
				pySERVER['WINDIR']               = ''
		if 'GATEWAY_INTERFACE' not in pySERVER.keys():
				GATEWAY_INTERFACE                = ''
				pySERVER['GATEWAY_INTERFACE']    = ''
		if 'REMOTE_PORT' not in pySERVER.keys():
				REMOTE_PORT                      = ''
				pySERVER['REMOTE_PORT']          = ''
		if 'HTTP_ACCEPT_LANGUAGE' not in pySERVER.keys():
				HTTP_ACCEPT_LANGUAGE             = ''
				pySERVER['HTTP_ACCEPT_LANGUAGE'] = ''
		if 'REQUEST_SCHEME' not in pySERVER.keys():
				REQUEST_SCHEME                   = ''
				pySERVER['REQUEST_SCHEME']       = ''
		if 'REQUEST_TIME_FLOAT' not in pySERVER.keys():
				REQUEST_TIME_FLOAT               = ''
				pySERVER['REQUEST_TIME_FLOAT']   = ''
		if 'HTTP_ACCEPT_ENCODING' not in pySERVER.keys():
				HTTP_ACCEPT_ENCODING             = ''
				pySERVER['HTTP_ACCEPT_ENCODING'] = ''
		if 'HTTP_REFERER' not in pySERVER.keys():
				HTTP_REFERER                     = ''
				pySERVER['HTTP_REFERER']         = ''
		if 'HTTP_PRAGMA'  not in pySERVER.keys():
				HTTP_PRAGMA                      = ''
				pySERVER['HTTP_PRAGMA']          = ''
		if 'HTTP_DNT'     not in pySERVER.keys():
				HTTP_DNT                         = ''
				pySERVER['HTTP_DNT']             = ''
		if 'HTTP_COOKIE'  not in pySERVER.keys():
				HTTP_COOKIE                      = ''
				pySERVER['HTTP_COOKIE']          = ''

				
def display_pythorinfo():

	#global pySERVER      # only when editing...
	#global pyGET		  #...
	#global pyGET		  #...
	#global pyFILES		  #...
	
	out=''
 	
	apache_vars=['HTTP_HOST', 'HTTP_USER_AGENT', 'HTTP_ACCEPT', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_ACCEPT_ENCODING', 
'HTTP_CONNECTION','HTTP_CACHE_CONTROL', 'PATH', 'SystemRoot', 'COMSPEC', 'PATHEXT', 'WINDIR', 'SERVER_SIGNATURE', 
'SERVER_SOFTWARE','SERVER_NAME', 'SERVER_ADDR', 'SERVER_PORT', 'REMOTE_ADDR', 'DOCUMENT_ROOT', 'REQUEST_SCHEME', 
'CONTEXT_PREFIX','CONTEXT_DOCUMENT_ROOT', 'SERVER_ADMIN', 'SCRIPT_FILENAME', 'REMOTE_PORT', 'GATEWAY_INTERFACE', 
'SERVER_PROTOCOL','REQUEST_METHOD', 'QUERY_STRING', 'REQUEST_URI', 'SCRIPT_NAME'  ]	

	out += <% 
		<h1>Apache Envionment Variables </h1>
	
		<table border="1">
	%>	

	for item in apache_vars:
		out += <%

			<tr>	<td> {**{item}**} </td>    <td> {**{value}**} </td>    </tr>

	%>.format(  value = pySERVER[item]  )                                 

	out += <%	
		</table>

		<h1>Printing the pySERVER superglobal variables</h1>
		<table border="1">
	%>

	for var_name, item in pySERVER.items():
		out += <%

			<tr>	<td> {**{name}**} </td>    <td> {**{value}**} </td>    </tr>

	%>.format( name = var_name , value = item )

	out += <%
		</table>

		<h1>Printing the pyGET superglobal variable contents</h1>
		<table border="1">
	%>

	for var_name, item in pyGET.items():
		out += <%

			<tr>	<td> {**{name}**} </td>    <td> {**{value}**} </td>    </tr>

	%>.format( name = var_name , value = item )

	out += <%
		</table>
	
		<h1>Printing the pyPOST superglobal variable contents</h1>
		<table border="1">
	%>

	for var_name, item in pyPOST.items():
		out += <%

			<tr> <td> {**{name}**} </td>  <td> {**{value}**} </td> </tr>

	%>.format( name = var_name , value = item )

	out += <%	
		</table>
		
		<h1>Printing the pyFILES superglobal variable contents</h1>
		<table border="1">
	%>

	for var_name, item in pyFILES.items():
		out += <%

			<tr> <td> {**{name}**} </td>  <td> {**{value}**} </td> </tr>

	%>.format( name = var_name , value = item )

	out += <%	</table>	%>

	return out
	
# (exactly) from simple_preprocesor.py 
def get_string_tag_to_tag_read_source(file, start_tag, end_tag):  # same function to get_string_tag_to_tag the PHP version I wrote
	
	s=''
	with open( file, 'r' ) as fp:  #file pointer (of features file 
		s = fp.read()
	
	start = s.find(start_tag)
	
	if (start == -1):
		print 'early exit, could not find start_tag ' + start_tag + ' in file: ' + features_file + '<br>' 
		sys.exit(1)
		
	end = s.find(end_tag)
	
	if (end == -1):
		print 'early exit, could not find end_tag' + end_tag + ' in file: ' + features_file + '<br>'
	
	return s[start+len(start_tag):end]
	

def replace_when_yes(value, salted_opentag, salted_closetag,  bool_when,  salt_flavor):  # yes  as  true
	
	if (bool_when):
		return value.replace( salted_opentag, '<pre>' ).replace( salted_closetag, '</pre>' )
	else:
		return value
		
def get_fullsource(comments = True, pretags=False): # True initially
	
	salt = uuid.uuid4().hex
	
	#print '<br>'+ 'GET_FULLSOURCE' + '<br>'

	source = __file__ # compiled version _compiled.py  (note: not the current file, e.g.,  *_pyThor_features_txt.py )

	features_file = 'simple_preprocessor_pyThor_features_txt.py'	# test if feature file exists (should)
	
	opentag   = '# PYTHON QUICK TAGS FEATURES OPEN TAG #'.replace(' ','_')
	closetag  = '# PYTHON QUICK TAGS FEATURES CLOSE TAG #'.replace(' ','_')
	features  = get_string_tag_to_tag_read_source( PREPROCESSOR_FOLDER+features_file, opentag, closetag )

	opentag   = '# MAIN PROGRAM OPEN TAG #'.replace(' ','_')
	closetag  = '# MAIN PROGRAM CLOSE TAG #'.replace(' ','_')
	mainintro = get_string_tag_to_tag_read_source( PREPROCESSOR_FOLDER+features_file, opentag, closetag )

	source = os.path.basename(source).replace('_compiled.py', '.py')
	source = SOURCE_FOLDER+'/'+source

	with open(source, 'r') as rp:
		s = rp.read()
	
	out = '*--START OF FULL SOURCE--*'.replace(' ', '_')
	
	out += '*openpre-*'+salt  if (pretags) else   ''
	
	out += features + s + mainintro

	out += '*closepre-*'+salt if (pretags) else   ''
	
	out += '*--END OF FULL SOURCE--*'.replace(' ', '_')
	
	
	return replace_when_yes( pyQuickTags(out).htmlentities(), salted_opentag='*openpre-*'+salt, salted_closetag='*closepre-*'+salt, bool_when=pretags, salt_flavor = salt )


def display_features():

	features_file = 'simple_preprocessor_pyThor_features_txt.py'	# test if feature file exists (should)

	opentag   = '# FEATURES LIST OPEN TAG #'.replace(' ','_')
	closetag  = '# FEATURES LIST CLOSE TAG #'.replace(' ','_')
	features  = get_string_tag_to_tag_read_source( PREPROCESSOR_FOLDER+features_file, opentag, closetag )

	return pyQuickTags(features).htmlentities()
	
	
def print_args(s, intro=''):		# to view the arguments that are sent to PyThor (from PHP)
	print( intro )
	for x, item in enumerate(s):
		print( 'ARG:'+str(x)+'(' + item + ')' ) + '<br>'

		

#_PYTHON_QUICK_TAGS_FEATURES_CLOSE_TAG_#
# DO NOT EDIT THE TEXT ON THE PREVIOUS LINE, used to automatically generate _compiled.py source code #




# DO NOT EDIT THE TEXT ON THE NEXT LINE, also used to automatically generate _compiled.py source code #
#_MAIN_PROGRAM_OPEN_TAG_#


if __name__ == "__main__":  # in the case not transferring data from php, then simply revert to a previous version, commit
	
	
	print 'pyThor (pyThor,server-side) (rapydscript, python client-side javascript)'

	create_superglobals(sys.argv)
	
	if( not len(sys.argv) >= 2 ):
		print "argument is required, which domain name from the initial, starting PHP"
		sys.exit(1)
		
	output(name=sys.argv[1])

	
#_MAIN_PROGRAM_CLOSE_TAG_#
# DO NOT EDIT THE TEXT ON THE PREVIOUS LINE, this too is used to automatically generate _compiled.py source code #



# DO NOT EDIT THE TEXT ON THE NEXT LINE, this is used to automatically generate _compiled.py source code #
#_FEATURES_LIST_OPEN_TAG_#
Features List of PyThor

1. python quick tags <% %> (This is a triple double quoted string - TDQ )

2. There is the feature to use of   format variables on the python quick tag <% %>
e.g.,   <%  {**{variable_for_you}**}}  %>.format( variable_for_you = 'hello world' )

3. There is the feature to use of   .htmlentities method on the python quick tags <% %>
e.g.,   <%  this string will be converted to its htmlentities form %>.htmlentities()

4. There is the feature to access superglobal variables that exist as they do in PHP
   These variables have the same name as their PHP equivalent.
   Note that the keyword global must be used to access the superglobal variable within any function or method
   that you intend to use the variable.

5. There is the feature to print text to the web browser console    # prints to brower's console log

   print_wwwlog(any_text_to_print_to_console_log_string_or_variable_etc)


#_FEATURES_LIST_CLOSE_TAG_#
# DO NOT EDIT THE TEXT ON THE PREVIOUS LINE, this is used to automatically generate _compiled.py source code #



# END PRE PYTHOR FEATURES.PY WRITE OUTPUT #
### NOTE: DO NOT CHANGE THE TEXT ON THE PREVIOUS LINE!!!!	
