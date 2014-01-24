<?php
if(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true) {
?>
    <ul>
        <li class="bold">
            <img src="resources/img/glyphicons_330_blog.png"> 
            <a href="books.php">Всички книги</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_351_book_open.png"> 
            <a href="new_book.php">Добавете книга</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_034_old_man.png"> 
            <a href="new_author.php">Добавете автор</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_388_exit.png"> 
            <a href="logout.php">Изход</a>  
        </li>
    </ul>
<?php 
} else {
?>
    <ul>
        <li class="bold">
            <img src="resources/img/glyphicons_006_user_add.png"> 
            <a href="register.php">Регистрация</a>  
        </li> |  

        <li class="bold">
            <img src="resources/img/glyphicons_044_keys.png"> 
            <a href="index.php">Вход</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_330_blog.png"> 
            <a href="books.php">Всички книги</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_351_book_open.png"> 
            <a href="new_book.php">Добавете нова книга</a>  
        </li> |

        <li class="bold">
            <img src="resources/img/glyphicons_034_old_man.png"> 
            <a href="new_author.php">Добавете автор</a>  
        </li>
    </ul>
<?php
}
?>
