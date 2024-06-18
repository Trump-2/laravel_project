import './bootstrap';

import Search from './live-search';

// 如果頁面上存在該搜尋 icon ( 帶有這個 class ) 才想要實體化 js class Search 的物件
if(document.querySelector(".header-search-icon")) {
    new Search();
}
