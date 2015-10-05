<?php
namespace Crm\AddressesBundle\Services;

class StaticFunctions
{
    /**
     * Запись лога
     */
    public static function writeLog( $filename, array $messages )
    {
        $log = '';
        foreach( $messages as $title => $value )
        {
            $log .= sprintf("%s: %s\n", $title, $value);
        }
        if( $log )
        {
            $log = sprintf("%s-----\n%s#####\n",date('Y-m-d H:i:s'),$log);
            $fh = fopen($filename, "a+");
            fwrite($fh, $log."\n\n"); 
            fclose($fh);
        }
    }
    
    /**
     * generatePass
     * 
     */
    public static function generatePass($literal=true,$number=10)
    {
        if($literal)
        {
            $arr = array(
                'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z',
                '1','2','3','4','5','6','7','8','9','0',
            );
            $pass = "";
            for($i = 0; $i < $number; $i++)
            {
                $index = rand(0, count($arr) - 1);
                $pass .= $arr[$index];
            }
        }
        else
        {
            $pass = rand(1000001,9999999);
        }
        return $pass;
    }
    
    /**
     * generateEprasys
     * 
     */
    public static function generateEprasys($parent_eprasys,$name,$prefix=false)
    {
        $eprasys_name = trim( $name);
        $trans = array('/'=>'x','-'=>'_','а'=>'A','б'=>'B','в'=>'V','г'=>'G','д'=>'D','е'=>'E','ж'=>'J','з'=>'Z',
                              'и'=>'I','к'=>'K','л'=>'L','м'=>'M','н'=>'N','о'=>'O','п'=>'P','р'=>'R','с'=>'S','т'=>'T',
                              'у'=>'U','ф'=>'F','х'=>'H','ц'=>'C','ч'=>'C','ш'=>'S','щ'=>'S','э'=>'E','ю'=>'U','я'=>'Y');
        $eprasys_name = strtr($eprasys_name,$trans);
        $eprasys_name = preg_replace('/([K])([0-9A-Z])/','k$2',$eprasys_name);
        $eprasys_name = $prefix.$parent_eprasys.$eprasys_name;
                    
        return $eprasys_name;
    }
    

}
