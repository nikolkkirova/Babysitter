// Избираме елемента userBox, който се намира в .header .header-2 .user-box
let userBox = document.querySelector('.header .header-2 .user-box');

// Когато потребителят натисне бутона с ID 'user-btn', най - вдясно в навигационното меню
document.querySelector('#user-btn').onclick = () => {
   // Добавяме или премахваме класа 'active' на userBox (показва/скрива полето за потребителя)
   userBox.classList.toggle('active');
   // Премахваме активния клас от навигационното меню, ако е отворено
   navbar.classList.remove('active');
}

// При скролиране на страницата
window.onscroll = () => {
   // Скриваме полето за потребителя, ако е отворено
   userBox.classList.remove('active');
   // Скриваме навигационното меню, ако е отворено
   navbar.classList.remove('active');

   // Ако страницата е скролирана надолу повече от 60 пиксела
   if (window.scrollY > 60) {
      // Добавяме клас 'active' към заглавната част, за да промени стила си (например фиксирана позиция)
      document.querySelector('.header .header-2').classList.add('active');
   } 
   
   else {
      // Ако страницата е скролирана нагоре, премахваме класа 'active' от заглавната част
      document.querySelector('.header .header-2').classList.remove('active');
   }
}