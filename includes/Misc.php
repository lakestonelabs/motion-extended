<?php

/* 
 * Copyright (C) 2020 Lakestone Labs
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


Class Misc
{
    
    /*
    This should be used for short-running programs that terminate.  This should
    not be used for long-running programs.
    */
    public static function runLocalCommand($command, $debug = false)
    {
        $return_value = null;
        $output = null;
        
        if(!empty($command))
        {
            exec($command, $output, $return_value);
        }
        
        // Make sure the $return_value is an integer.
        $return_value = (int) $return_value;
        
        if($return_value === 0)
        {
            if(sizeof($output) == 1)
            {
                if($debug)
                {
                    return array("output" => $output[0], "return_value" => $return_value);
                }
                else
                {
                    return $output[0];
                }
            }
            else if(sizeof($output) > 1)
            {
                if($debug)
                {
                    return array("output" => $output, "return_value" => $return_value);
                }
                else
                {
                    return $output;
                }
            }
            else
            {
                if($debug)
                {
                    return array("output" => $output, "return_value" => $return_value);
                }
                else
                {
                    return $output;
                }
            }
        }
        else if($return_value === 255)
        {  
            return array("output" => "ERROR running command: " . $command, "return_value" => $return_value);
        }
        else if ($return_value > 0)
        {
            if(sizeof($output) > 1)
            {
                // Got an error from command.
                if($debug)
                {
                    return array("output" => $output, "return_value" => $return_value);
                }
                else
                {
                    return $return_value;
                }
            }
            else
            {
                // Got an error from command.
                if($debug)
                {
                    if(isset($output[0]))
                    {
                        return array("output" => $output[0], "return_value" => $return_value);
                    }
                    else
                    {
                        return array("output" => null, "return_value" => $return_value);
                    }
                }
                else
                {
                    return $return_value;
                }
            }
        }
    }

    /*
    This should be used for long-running programs.  It is much more powerful than the 'runLocalCommand()'
    in that it uses the 'proc_open()' php function which allows you to read/write input/output to and from
    the program and also allows you to get details about the program such as pid, etc.  See php's doco
    on the proc_open() function for more details.

    RETURNS: An array containing both the resource representing the process and the descriptorspec array.
    */
    public static function runLocalProgram($program, $args_array, $log_location = false)
    {
        if($log_location === false)
        {
            $log_location = "/tmp/".basename($program).".log";
        }
        
        foreach($args_array as $this_arg_index => $this_arg)
        {
            $args_array[$this_arg_index] = escapeshellarg($this_arg);
        }

        // Taken from php.net to setup descriptors.
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("file", $log_location, "a") // stderr is a file to write to
         );
        
        if(empty($program))
        {
            throw new Exception(__METHOD__.": Parameter \$program must not be empty.");
        }

        if(!is_file($program))
        {
            throw new Exception(__METHOD__.": Parameter \$program (".$program.") must be a file.");
        }

        $cwd = "/tmp";
        $process = proc_open(escapeshellcmd($program)." ". implode(" ", $args_array), $descriptorspec, $pipes, $cwd, null);
         
        if(is_resource($process))
        {
            return array("resource" => $process, "pipes" => $pipes);
        }
        else
        {
            throw new Exception(__METHOD__.": Failed to execute program: ".$program);
        }

    }
}



