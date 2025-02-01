// Избираме елемента userBox, който се намира в .header .header-2 .user-box
let userBox = document.querySelector('.header .header-2 .user-box');

// Когато потребителят натисне бутона с ID 'user-btn'
document.querySelector('#user-btn').onclick = () => {
   // Добавяме или премахваме класа 'active' на userBox (показва/скрива полето за потребителя)
   userBox.classList.toggle('active');
   // Премахваме активния клас от навигационното меню, ако е отворено
   navbar.classList.remove('active');
}

// Избираме навигационното меню
let navbar = document.querySelector('.header .header-2 .navbar');
// Избираме секцията за логване/активност
let logActivity = document.querySelector('.log-activity');

// Когато потребителят натисне бутона с ID 'menu-btn'
document.querySelector('#menu-btn').onclick = () => {
   // Добавяме или премахваме класа 'active' на навигацията (показва/скрива менюто)
   navbar.classList.toggle('active');
   // Премахваме активния клас от userBox, ако е отворен
   userBox.classList.remove('active');
}

// При скролиране на страницата
window.onscroll = () => {
   // Скриваме полето за потребителя, ако е отворено
   userBox.classList.remove('active');
   // Скриваме навигационното меню, ако е отворено
   navbar.classList.remove('active');
   // Скриваме секцията за лог активност
   logActivity.classList.remove('active');

   // Ако страницата е скролирана надолу повече от 60 пиксела
   if (window.scrollY > 60) {
      // Добавяме клас 'active' към заглавната част, за да промени стила си (например фиксирана позиция)
      document.querySelector('.header .header-2').classList.add('active');
      // Показваме секцията за лог активност
      document.querySelector('.log-activity').classList.add('active');
   } 
   
   else {
      // Ако страницата е скролирана нагоре, премахваме класа 'active' от заглавната част
      document.querySelector('.header .header-2').classList.remove('active');
   }
}