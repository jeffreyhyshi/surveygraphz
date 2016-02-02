<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
    <script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="d3.v3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="drawgraph.js" type="text/javascript" charset="utf-8"></script>

    <style>
    *{
        margin: 0;
    }
    body{
        width:900px;
        margin-left:auto;
        margin-right:auto;
    }
    h1 {
        text-align:center;
        margin:20px;
        font-family:sans-serif;
    }
    h4{
        text-decoration:none;
        text-align:center;
        margin:10px;
    }
    p{
        font-family:sans-serif;
    }
    #footer{
        height:50px;
        width:auto;
        text-align:center;
    }
    /*.graph{
        opacity: 0.5;
        transition: opacity 2s;
        -webkit-transition: opacity 2s; /* Safari */
    /*}
    .graph:hover{
        opacity: 1;
    } */
    </style>

</head>
<body>
    <?php
        $c = mysqli_connect("localhost","albusd_jshi","password123","albusd_jshi");
        if (mysqli_connect_errno()) {
            echo "-1";
        }

        if (isset($_GET['r'])) {
            $passdata = array();
            $surveyurl = $_GET['r'];
            $getsurveyquery = "SELECT * FROM surveys WHERE url='$surveyurl'";

            $surveyarray = mysqli_fetch_assoc(mysqli_query($c, $getsurveyquery));

            $surveyname = $surveyarray['name'];
            $s_id = (int) base_convert($surveyurl, 36, 10);

            $getquestionsquery = "SELECT * FROM questions WHERE survey='$s_id' ORDER BY q_order";
            $questionsresult = mysqli_query($c, $getquestionsquery);
            $questionsarray = array();
            while ($row = mysqli_fetch_assoc($questionsresult)) {
                $questionsarray[] = $row;
            }

            foreach ($questionsarray as $question) {
                $q_id = $question['q_id'];
                $getchoicesquery = "SELECT name, count FROM choices WHERE question='$q_id' ORDER BY c_order";
                $choicesarray = array();
                $choicesresult = mysqli_query($c, $getchoicesquery);
                while ($c_row = mysqli_fetch_assoc($choicesresult)) {
                    $choicesarray[] = $c_row;
                }
                $choicenamearray = array();
                $choicecountarray = array();
                foreach ($choicesarray as $choice) {
                    $choicenamearray[] = $choice['name'];
                    $choicecountarray[] = $choice['count'];
                }

                $passdata[] = ['question' => $question['name'],
                               'choices' => $choicenamearray,
                               'responses' => $choicecountarray];

            }

            $jsonquestions = json_encode($passdata);

            echo "<input id='surveyname' type='hidden' value='$surveyname'/>";
            echo "<input id='surveyquestions' type='hidden' value='$jsonquestions'/>";
        }
        
    ?>
    <h1>Results</h1>
    <div id="footer">
        <p>Click <a href="index.html">here</a> to create another survey.<p>
    </div>
</body>
</html>