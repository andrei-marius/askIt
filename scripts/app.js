"use strict";

(function toastrOptions(){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
}());

// async function getTopics(){
//     try{
//         const connection = await fetch('apis/api-get-topics.php')
//         const data = await connection.json()

//         if(data.status === 1){
//             const userName = data.userName
//             data.topics.forEach(function(topic){
//               const divTopic = `<div class='topic' id='${topic.id}'>
//                 <span>Posted by '${userName}'</span>
//                 <h1>${topic.title}</h1>
//                 <p>${topic.description}</p>
//               </div>`

//               document.querySelector("#topics").insertAdjacentHTML('beforeend', divTopic)
//             })
//         }else{
//           console.log(data.message)
//         }
//     }
//     catch(err){
//         console.log(err)
//     }
// }
// window.onload = getTopics()

async function createTopic(){
    document.querySelector('#topicBtn').innerHTML = `<svg version="1.1" id="loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    width="20px" height="20px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
        <path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
            <animateTransform attributeType="xml"
            attributeName="transform"
            type="rotate"
            from="0 25 25"
            to="360 25 25"
            dur="0.6s"
            repeatCount="indefinite"/>
        </path>
    </svg>`

    try{
        const formData = new FormData(document.querySelector("#topicForm"))

        const options = {
            method: 'POST',
            body: formData
        }

        const connection = await fetch('apis/api-create-topic.php', options)
        const data = await connection.json()

        if(data.status === 1){
            document.querySelector("#topicForm").reset()
            toastr['success'](data.message)
        }else{
            toastr['error'](data.message)
        }
    }
    catch(err){
        console.log(err)
    }
    document.querySelector('#topicBtn').innerHTML = 'create topic'  
}

document.querySelector('#topicBtn').addEventListener('click', createTopic)

async function logOut(){
    try{
      const connection = await fetch('apis/api-logout.php')
      const data = await connection.json()
  
      if(data){
        window.location.replace('login.php')
      }
    }
    catch(err){
      console.log(err)
    }
  }

  document.querySelector('#logout').addEventListener('click', logOut)