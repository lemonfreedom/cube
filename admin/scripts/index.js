// 显示通知
const showNotice = (message, type = 'info') => {
    let content = `<div class="notice ${type}">${message}</div>`;
    document.body.innerHTML += content;
}

// cookie 通知
let notice = Cookies.get('inspiration_notice');
if (notice) {
    const { message, type } = JSON.parse(notice);
    showNotice(message, type);
    Cookies.remove('inspiration_notice');
};

// 汉堡包切换
const burger = document.querySelector('#burger');
if (burger) {
    burger.addEventListener('click', function () {
        document.querySelector('#burgerContent').classList.toggle('show');
        document.body.classList.toggle('mask');
    });
}

// 标签页
let tabs = document.querySelectorAll('.tabs');
if (tabs.length > 0) {
    tabs.forEach(tabEl => {
        tabEl.querySelectorAll('a').forEach(el => {
            el.addEventListener('click', function (e) {
                tabEl.querySelectorAll('li').forEach(el => { el.classList.remove('is-active') });
                this.parentNode.classList.add('is-active');
                let tabContent = document.querySelectorAll(`${tabEl.dataset.content} .tab-content`);
                let activeContent = this.dataset.tab;
                tabContent.forEach(el => {
                    if (!el.classList.contains('is-hidden')) {
                        el.classList.add('is-hidden');
                    }
                    if (el.dataset.tab === activeContent) {
                        el.classList.remove('is-hidden');
                    }
                });
            });
        });
    });
}

// 文章文件上传
// let postUpload = document.querySelector('#postUpload');
// if (postUpload) {
//     postUpload.querySelector('#uploadButton').addEventListener('click', function (e) {
//         let input = document.createElement('input');
//         input.setAttribute('type', 'file');
//         input.setAttribute('multiple', 'multiple');
//         input.click();
//         input.addEventListener('change', function (e) {
//             [...this.files].forEach(file => {
//                 let formData = new FormData();
//                 formData.append('file', file);
//                 fetch('/file/upload', {
//                     method: 'post',
//                     body: formData
//                 }).then(res => res.json()).then(res => {
//                     if (res.code === 0) {
//                         postUpload.appendChild
//                         postUpload.insertAdjacentHTML('beforeend', `<div class="panel-block is-flex-direction-column is-align-items-flex-start" data-type="fileItem" data-cid="${res.data.cid}">
//                             <div class="mb-2">
//                                 <strong class="is-text-wrap">${res.data.name}</strong>
//                             </div>
//                             <div class="is-flex is-align-items-center">
//                                 <strong class="has-text-grey-light">${res.data.size}</strong>
//                                 <a class="button is-info ml-2" href="">
//                                     <span class="icon is-small">
//                                         <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
//                                             <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
//                                         </svg>
//                                     </span>
//                                 </a>
//                                 <a class="button is-danger ml-2" href="">
//                                     <span class="icon is-small">
//                                         <svg width="1rem" height="1rem" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
//                                             <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z" />
//                                         </svg>
//                                     </span>
//                                 </a>
//                             </div>
//                         </div>`);
//                     }
//                 });
//             });
//         });
//     });
// }

// postUpload.addEventListener('click', function (e) {
//     if (e.target.dataset.type === 'delete') {
//         if (confirm('删除后无法恢复，是否确认删除？')) {
//             let formData = new FormData();
//             formData.append('cid', e.target.dataset.cid);
//             fetch('/file/delete', {
//                 method: 'post',
//                 body: formData
//             }).then(res => res.json()).then(res => {
//                 if (res.code === 0) {
//                     document.querySelectorAll('[data-type="fileItem"]').forEach(el => {
//                         if (el.dataset.cid === e.target.dataset.cid) {
//                             el.remove();
//                         }
//                     });
//                 }
//             });
//         }
//     }
// });
