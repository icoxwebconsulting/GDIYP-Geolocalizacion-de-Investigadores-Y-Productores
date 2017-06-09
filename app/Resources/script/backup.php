<?php
    $parameters = file_get_contents("..\..\config\parameters.yml");
    
    $host = get_string($parameters,"database_host: ","\n");
    $port = get_string($parameters,"database_port: ","\n");
    $user = get_string($parameters,"database_user: ","\n");
    $pass = get_string($parameters,"database_password: ","\n");
    $database = get_string($parameters,"database_name: ","\n");
    
    if ($pass=="null" || $pass=="~" || $pass=="" || $pass=="none") {$pass="";}

    $string_conection = 'mysql:host='.$host.';dbname='.$database.';port='.$port;
    $conn = new PDO($string_conection, $user, $pass, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);

    /********************************************************************************/
    // Parameters: filename.csv table_name
    ob_implicit_flush();

    $argv = $_SERVER['argv'];

    if($argv[1]) { $file = $argv[1]; }
    else {
        echo "Please provide a file name\n"; exit; 
    }
    
    $table = "data_to_import";

    echo "IMPORTING DATA. PLEASE WAIT...".PHP_EOL;
    /********************************************************************************/
    // Get the first row to create the column headings

    $fp = fopen($file, 'r');
    $frow = fgetcsv($fp);
    $count = 1;
    $columns = '';
    foreach($frow as $column) {
        $column = 'field'.$count;
        if($columns) $columns .= ', ';
        $columns .= "`$column` text";
        $count++;
    }
    $drop = "drop table if exists $table ;";
    $conn->exec($drop);

    $create = "create table if not exists $table ($columns);";
    $conn->exec($create);

    /********************************************************************************/
    // Import the data into the newly created table.

    //$file = $_SERVER['PWD'].'/'.$file;
    $q = "load data local infile '$file' into table $table fields terminated by ',' enclosed by '\"' ignore 1 lines";
    $conn->exec($q);

    //Obtaining all data
    $all = "SELECT * FROM ".$table;
    $allQuery = $conn->prepare($all);
    $allQuery->execute();
    $allResult = $allQuery->fetchall();

    $log = "";
        
    foreach($allResult as $row) {
        //user: first name and last_name
        $first_name = "";
        $last_name = "";
        if (strpos($row['field2'], ',')) {
            $nameArray = explode(",", $row['field2']);
            $first_name = $nameArray[1];
            $last_name = $nameArray[0];
        }
        else {
            $nameArray = explode(" ", $row['field2']);
            if (count($nameArray)==2) {
               $first_name = $nameArray[1];
               $last_name = $nameArray[0];
            }
            else if (count($nameArray)==3) {
               $first_name = $nameArray[1]." ".$nameArray[2];
               $last_name = $nameArray[0];
            }
            else if (count($nameArray)==4) {
               $first_name = $nameArray[2]." ".$nameArray[3];
               $last_name = $nameArray[0]." ".$nameArray[1];
            }
            else if (count($nameArray)>=5) {
               $first_name = $nameArray[2]." ".$nameArray[3]." ".$nameArray[4];
               $last_name = $nameArray[0]." ".$nameArray[1];
            }		
        }

        $first_name = ucwords(strtolower($first_name));
        $last_name = ucwords(strtolower($last_name));

        //user: username, username_canonical and email
        unset($email);
        if (strpos($row['field7'], '@'))
            $email = strtolower(trim($row['field7']));
        else if (strpos($row['field8'], '@'))
            $email = strtolower(trim($row['field8']));

        if (isset($email)) {
            $emailQuery = "SELECT email FROM users WHERE email = '".$email."'";
            $emailQueryResult = $conn->prepare($emailQuery); 
            $emailQueryResult->execute();
            $emailCount = count($emailQueryResult->fetchAll()); 
            if ($emailCount > 0) {
                $log .= "User not created - Duplicate Email address".PHP_EOL;
                $log .= "First Name: ".$first_name.PHP_EOL;
                $log .= "Last Name: ".$last_name.PHP_EOL;
                $log .= "------------------------------------".PHP_EOL;
                continue;
            }
            else {
                $usernameArray = explode("@", $email);            
                $username = strtolower(trim($usernameArray[0]));
            }
        }
        else {
            $log .= "User not created - Email address invalid or does not exist".PHP_EOL;
            $log .= "First Name: ".$first_name.PHP_EOL;
            $log .= "Last Name: ".$last_name.PHP_EOL;
            $log .= "------------------------------------".PHP_EOL;
            continue;
        }

        $existsUsername = true;
        $usernameCount = 0;
        $count = 1;
        while ($existsUsername) {
                $usernameQuery = "SELECT username FROM users WHERE LOWER(username) = '".$username."'";
                $usernameQueryResult = $conn->prepare($usernameQuery); 
                $usernameQueryResult->execute();
                $usernameCount = count($usernameQueryResult->fetchAll()); 
                if ($usernameCount == 0)
                        $existsUsername = false;
                else {
                        $username.=$count;
                        $count++;
                }
        }

        $userInsertQuery  = "INSERT INTO users (username, username_canonical, email, email_canonical, enabled, salt, password, locked, expired, roles, credentials_expired, first_name, last_name, reported, complete_data, image_name, created, modified) "; 
        $userInsertQuery .= "VALUES ('".$username."','".$username."','".$email."','".$email."',1,'d9kbq4tq0jk0kcw0coos840gc0og0c8','$2y$15\$d9kbq4tq0jk0kcw0coos8uiF0w7IhthTeO0qbAiWzf8qf7GbOIbuu',0,0,'a:1:{i:0;s:17:\"ROLE_INVESTIGATOR\";}',0,'".filter($first_name)."','".filter($last_name)."',0,0,'user.jpg','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')";
        $userInsertQueryResult = $conn->prepare($userInsertQuery);
        $userInsertQueryResult->execute();
        $userId = $conn->lastInsertId();

        $log .= "Username Created: ".$username." (User ID: ".$userId.")".PHP_EOL;
        $log .= "First Name: ".$first_name.PHP_EOL;
        $log .= "Last Name: ".$last_name.PHP_EOL;
        $log .= "Email: ".$email.PHP_EOL;

        //case_study: name
        $caseStudyName = ucwords(strtolower($row['field21']));
        //case_study: description
        $caseStudyDescription = ucwords(strtolower($row['field23']));
        //case_study: keyword
        $caseStudyKeyword = ucwords(strtolower($row['field24']));
        //case_study: investigation_lines
        $caseStudyInvestigationLine = ucwords(strtolower($row['field22']));
        //case_study: research_group
        $caseStudyResearchGroup = ucwords(strtolower($row['field25']));
        //case_study: related_institution
        $caseStudyRelatedInstitution = "";
        //case_study: links
        $caseStudyLinks = ucwords(strtolower($row['field50']));
        //case_study: contact_info
        $caseStudyContactInfo = "";

        $caseStudyInsertQuery  = "INSERT INTO case_study (name, description, keywords, investigation_lines, research_group, related_institution, links, contact_info) "; 
        $caseStudyInsertQuery .= "VALUES ('".filter($caseStudyName)."','".filter($caseStudyDescription)."','".filter($caseStudyKeyword)."','".filter($caseStudyInvestigationLine)."','".filter($caseStudyResearchGroup)."','".filter($caseStudyRelatedInstitution)."','".filter($caseStudyLinks)."','".filter($caseStudyContactInfo)."')";
        $caseStudyInsertQueryResult = $conn->prepare($caseStudyInsertQuery);
        $caseStudyInsertQueryResult->execute();
        $caseStudyId = $conn->lastInsertId();
        
        $log .= "Case Study Name: ".$caseStudyName.PHP_EOL;
        $log .= "Case Study Description: ".$caseStudyDescription.PHP_EOL;
        $log .= "Case Study Keyword: ".$caseStudyKeyword.PHP_EOL;
        $log .= "Case Study Investigation Line: ".$caseStudyInvestigationLine.PHP_EOL;        
        $log .= "Case Study Research Group: ".$caseStudyResearchGroup.PHP_EOL;
        $log .= "Case Study Related Institution: ".$caseStudyRelatedInstitution.PHP_EOL;
        $log .= "Case Study Links: ".$caseStudyLinks.PHP_EOL;
        $log .= "Case Study Contact Info: ".$caseStudyContactInfo.PHP_EOL;
        
        //user_profile: residence_place
        $residencePlaceQuery = "SELECT c.id, c.name FROM cities c WHERE c.region IN (SELECT id FROM regions r WHERE r.country IN (SELECT id FROM countries WHERE UPPER(name) like '%".strtoupper($row['field5'])."%')) LIMIT 1";
        $residencePlaceResult = $conn->prepare($residencePlaceQuery); 
        $residencePlaceResult->execute();

        $residencePlace = "";
        while ($residencePlaces = $residencePlaceResult->fetch(PDO::FETCH_ASSOC)) {
            $residencePlace = $residencePlaces["id"];
            $log .= "Residence Place: ".$residencePlaces["name"]." (City ID: ".$residencePlace.")".PHP_EOL;
            $log .= "Residence Country: ".ucwords(strtolower($row['field5'])).PHP_EOL;
        }
        if ($residencePlace == "") {
            $log .= "Residence Place: Empty".PHP_EOL;
            $log .= "Residence Country: Empty".PHP_EOL;
        }

        //user profile: job_title
        $job_title = $row['field17'];
        if ($job_title=="")
            $log .= "Job title: Empty".PHP_EOL;
        else
            $log .= "Job title: ".$job_title.PHP_EOL;

        //user_profile: institution
        $institution = "";
        if ($row['field11']!="") {
            $institutionQuery = "SELECT id FROM institutions WHERE UPPER(name) = '".strtoupper($row['field11'])."' LIMIT 1";
            $institutionQueryResult = $conn->prepare($institutionQuery); 
            $institutionQueryResult->execute();

            while ($institutions = $institutionQueryResult->fetch(PDO::FETCH_ASSOC)) {
                $institution = $institutions["id"];                
            }
            if ($institution == "") {
                $institutionTypeQuery = "SELECT id FROM institution_types WHERE UPPER(name) = '".strtoupper($row['field10'])."' LIMIT 1";
                $institutionTypeQueryResult = $conn->prepare($institutionTypeQuery); 
                $institutionTypeQueryResult->execute();

                $institutionType = "";
                while ($institutionTypes = $institutionTypeQueryResult->fetch(PDO::FETCH_ASSOC)) {
                    $institutionType = $institutionTypes["id"];                
                }

                if ($institutionType == "") {
                    $institutionType = 9; //Institution Type by default: Others/Otros
                }
                $institutionInsertQuery  = "INSERT INTO institutions (type, name) ";
                $institutionInsertQuery .= "VALUES ('".$institutionType."','".filter(ucwords(strtolower($row['field11'])))."')";
                $institutionInsertQueryResult = $conn->prepare($institutionInsertQuery);
                $institutionInsertQueryResult->execute();
                $institution = $conn->lastInsertId();
            }
            $log .= "Institution: ".ucwords(strtolower($row['field11']))." (Institution ID: ".$institution.")".PHP_EOL;            
        }
        else {
            $log .= "Institution Type: Empty".PHP_EOL;
            $log .= "Institution: Empty".PHP_EOL;
        }

        //user_profile: knowledge
        $knowledge = "";
        $knowledgeQuery = "SELECT id, name FROM knowledges WHERE UPPER(name) like '%".strtoupper($row['field18'])."%' LIMIT 1";
        $knowledgeQueryResult = $conn->prepare($knowledgeQuery); 
        $knowledgeQueryResult->execute();

        while ($knowledges = $knowledgeQueryResult->fetch(PDO::FETCH_ASSOC)) {
            $knowledge = $knowledges["id"];
            $log .= "Knowledge: ".$knowledges["name"]." (Knowledge ID: ".$knowledge.")".PHP_EOL;
        }
        if ($knowledge == "") {
            $log .= "Knowledge: Empty".PHP_EOL;
        }
        
        //user_profile: study_topic
        $studyTopic = "";
        $studyTopicQuery = "SELECT id, name FROM study_topics WHERE UPPER(name) like '%".strtoupper($row['field19'])."%' LIMIT 1";
        $studyTopicQueryResult = $conn->prepare($studyTopicQuery); 
        $studyTopicQueryResult->execute();

        while ($studyTopics = $studyTopicQueryResult->fetch(PDO::FETCH_ASSOC)) {
            $studyTopic = $studyTopics["id"];
            $log .= "Study Topic: ".$studyTopics["name"]." (Study Topic ID: ".$studyTopic.")".PHP_EOL;
        }
        if ($studyTopic == "") {
            $log .= "Study Topic: Empty".PHP_EOL;
        }
        
        //user_profile: research_place
        $researchPlace = ""; //Empty
        
        //user_profile: address
        $address = ""; //Empty
        
        if ($institution=="")
           $institution = 'NULL';
        if ($knowledge=="")
           $knowledge = 'NULL';
        if ($studyTopic=="")
           $studyTopic = 'NULL';
        if ($researchPlace=="")
           $researchPlace = 'NULL';        
        if ($address=="")
           $address = 'NULL'; 
        if ($residencePlace=="")
           $residencePlace = 'NULL';
        
        $userProfileInsertQuery  = "INSERT INTO user_profile (user, institution, knowlegde, address, study_topic, research_place, residence_place, case_study, job_title) "; 
        $userProfileInsertQuery .= "VALUES (".$userId.",".$institution.",".$knowledge.",".$address.",".$studyTopic.",".$researchPlace.",".$residencePlace.",".$caseStudyId.",'".filter($job_title)."')";
        $userProfileInsertQueryResult = $conn->prepare($userProfileInsertQuery);
        $userProfileInsertQueryResult->execute();
        $userProfileId = $conn->lastInsertId();
        
        //ending log
        $log .= "------------------------------------".PHP_EOL.PHP_EOL;
    }
    file_put_contents('./logs/log_'.date("YmdHis").'.txt', $log, FILE_APPEND);

    echo "DONE!".PHP_EOL;
    
    $drop = "drop table if exists $table ;";
    $conn->exec($drop);    

    $conn = NULL;
    
    function filter ($str) {
        $str = str_replace("'", "''", $str); //scaping '
        return $str;
    }
    
    function get_string($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }    
?>
