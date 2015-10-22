
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of upload
 *
 * @author niteen
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

?>
<html>
    <head>
        <title>welcome to show</title>
   
    </head>
    <body>
        <div id = "div1" style="display: block;position: absolute;top: 250px;left: 150px">
        <h1>Image Upload</h1>
        <form method = "post" action="http://192.168.1.6/travelwebapp/api/v1/Images/upload1" enctype="multipart/form-data">
        <table border = 1px solid blueviolet>
            <tr>
                <td style="text-align: center;background-color: lightgoldenrodyellow">
                    Select Image 
                </td>
                <td>
                    <input type="file" name="upload" id="upload">
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>
                    <input type="submit" name="sub" id="sub1" value="Upload" style="background-color: green;border: 1px solid red;color: white">
                </td>
            </tr>>
        </table>
      </div>
       
        <div id = 'div2' style="position: absolute;top: 50px;left: 150px">
             <h1>Rest API Caller</h1>
              <table border = 1px solid blueviolet>
            <tr>
                <td style="text-align: center;background-color: lightgoldenrodyellow">
                   URL:
                </td>
                <td>
                    <input type="text" name="url" id="u1">
                </td>
            </tr>
            <tr>
                <td>
                    Method Name:
                </td>
                <td>
                    <input type="radio" name="sub" value="Post" >Post</br>
                    <input type="radio" name="sub" value="get" >Get
                </td>
            </tr>>
            <tr>
                <td>
                    Data(in Json):
                </td>
                <td>
                    <textarea name="mytext"> </textarea>
                </td>
            </tr>
        </table>
            </div>
            </form> 
    </body>
</html>
