<!DOCTYPE html>

<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
            <title>
            Bigbrother
            </title>
            <link rel="stylesheet" type="text/css" href="style.css">    
    </head>
    <body>
        <div id="wrapper">
            
            <div id="header">
                
                <a href="index.php"><div id="logo_small"></div></a>
         
            </div>
            
            <div id="settings_wrapper">
                
                <div id="settings_left_div">
                    
                    
                    <form>
                        <span class="name_span">Расписание: </span><br>
                        
                        <input type="checkbox"><span>Вечер</span><br>
                        <input type="checkbox"><span>Утро</span><br>
                        <input type="checkbox"><span>День</span><br>
                        <input type="checkbox"><span>Ночь</span><br>
                        <input type="checkbox"><span>Праздники</span><br>
                        
                        <input class="button_edit" type="submit" value="Изменить"><br>
                        <input class="button_del" type="submit" value="Удалить"><br>
                        
                    </form>
                    
                </div>
                
                    <div id="settings_left_shadow"></div>
                
                <div id="settings_center_div">
                    
                    <span>с 19:00 до 22:00</span>
                    <span>с 08:10 до 17:00</span>
                    <span>с 22:00 29 апреля до 10:00 14 мая</span>
                    <span>с 21:00 понедельника дл 6:00 вторника</span>
                    
                </div>
                
                    <div id="settings_right_shadow"></div>
                
                <div id="settings_right_div">
                    
                    <form>
                        <span class="name_span">Добавить новое:</span><br>
                        
                        <span class="name_span">Название</span><input type="text" size="20"><br>
                        
                        <span class="name_span">Начиная с:</span><br>
                        
                        <span>время</span>
                        <select>
                            <option></option>
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                        </select>
                        <select class="end_time">
                            <option></option>
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                        </select><br>
                        <span>день недели</span>
                        <select>
                            <option></option>
                            <option>понедельник</option>
                            <option>вторник</option>
                        </select><br>
                        <span>число</span>
                        <select>
                            <option></option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select><br>
                        <span>месяц</span>
                        <select>
                            <option></option>
                            <option>январь</option>
                            <option>ферваль</option>
                        </select><br>
                        

                        
                        <span class="name_span">Заканчивая:</span><br>
                        
                        <span>время</span>
                        <select>
                            <option></option>
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                        </select>
                        <select class="end_time">
                            <option></option>
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                        </select><br>
                        <span>день недели</span>
                        <select>
                            <option></option>
                            <option>понедельник</option>
                            <option>вторник</option>
                        </select><br>
                        <span>число</span>
                        <select>
                            <option></option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select><br>
                        <span>месяц</span>
                        <select>
                            <option></option>
                            <option>январь</option>
                            <option>ферваль</option>
                        </select><br>
                        
                        <input class="button_save" type="submit" value="Сохранить"><br>
                        
                    </form>
                    
                </div>
                
            </div>
                

                
        </div>
        
        <div id="bottom_settings_div_menu">
            
            <div id="bottom_settings_menu">
                <a href="#"><div id="button_bottom_settings_back"></div></a>
                <a href="#"><div id="button_bottom_settings_24h_rec"></div></a>
                <a href="#"><div id="button_bottom_settings_notification"></div></a>
                <a href="#"><div id="button_bottom_settings_timetable"></div></a>
                <a href="#"><div id="button_bottom_settings_personal_data"></div></a>
            </div>
            
        </div>

        
    </body>
</html>




<?php


?>