<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<body>
    Hey
    <input type='file' id="up_file" name='file'>
    <div class="init1 init" style="background-color:red">Addpost</div>
    <div class="init2 init" style="background-color:yellow">Addcomment</div>
    <div class="init3 init" style="background-color:green">Addreply</div>
    <div class="init4 init" style="background-color:blue">Fetch comments</div>
    <div class="init5 init" style="background-color:brown">Fetch Post 1</div>
    <div class="init6 init" style="background-color:red">Delete Post 1</div>
    <style>
        .init{
            max-width: 100px;
            border-radius:10px;
            margin: 10px;
            padding: 10px;
            cursor:pointer;
        }
    </style>

    <script>
        let addedfile = {};
        let resaddcount = 1;
        let data = {}

        // $('#up_file').on('input', function() {
            //     let fileobj = $('#up_file')[0].files[0];
            //     if (typeof(fileobj) !== 'undefined'){
            //         if (fileobj.size < 10097152){
            //             resaddcount += 1;
            //             let name = fileobj.name;
            //             addedfile['resadd'+resaddcount] = [fileobj, fileobj.name];
            //         }else{
            //             alert('File is too large');
            //         }       
            //     }else{
            //         console.log(typeof($('#file')[0]));
            //     }
        // });

        // $(".init").click(function(){
        //     var fd = new FormData();
            
        //     let count = 0;
        //     for (const key in addedfile) {
        //         const file = addedfile[key][0];
        //         count += 1;
        //         fd.append('file-'+ (count), file);          
        //     }

        //     data = {
        //         'name' : "ssaa",
        //         'price' : 10,
        //         'description' : "['required', 'min:100']",
        //         'code' : "['required']",
        //         'type' : "['required']",
        //         'category' : "['required']",
        //         'imagepaths' : "['required']",
        //     }

        //     fd.append('createset',JSON.stringify(data));
        //     fd.append('number_of_images', count);
            
            
        //     axios({
        //             method: 'POST',
        //             url: './apis/product/create',
        //             headers: {
        //                 'Cache-Control': 'no-cache',
        //                 'Pragma': 'no-cache',
        //                 "X-CSRF-TOKEN" : '{{csrf_token()}}'
        //             },        
        //             data:fd            
        //     }).then(response => {
        //         console.log(response);
        //     })
        //         .catch(error => console.error(error))
        // })
 

        $(".init1").click(function(){   
            data = {
                'title' : "post_title",
                'author_code' : "poster_code",
                'body' : "post_texts",
            }         
            axios({
                method: 'POST',
                url: './apis/post/create',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache',
                    "X-CSRF-TOKEN" : '{{csrf_token()}}'
                },     
                data:data            
            }).then(response => {
                console.log(response);
            })
                .catch(error => console.error(error))
        })

        $(".init2").click(function(){   
            data = {
                'post_code' : "v78Q",
                'parent_address' : "base",
                'author_code' : "author_code",
                'text' : "Lorem4",
            }        
            axios({
                method: 'POST',
                url: 'https://intern-chatapp.vercel.app/apis/post/addcomment',
                headers: {
                    'Access-Control-Allow-Origin':"*",
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache',
                    "X-CSRF-TOKEN" : '{{csrf_token()}}'
                },     
                data:data            
            }).then(response => {
                console.log(response);
            })
                .catch(error => console.error(error))
        })

        $(".init3").click(function(){   
            data = {
                'post_code' : "v78Q",
                'parent_address' : "VYz4aC",
                'author_code' : "author_code",
                'text' : "Lorem4",
            }        
            axios({
                method: 'POST',
                url: './apis/post/addcomment',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache',
                    "X-CSRF-TOKEN" : '{{csrf_token()}}'
                },     
                data:data            
            }).then(response => {
                console.log(response);
            })
                .catch(error => console.error(error))
        })

        $(".init4").click(function(){   
            data = {
                'post_code' : "v78Q",
                'node_address' : "base",
                'max_count':3,
                // 'max_layer_depth':1
            }        
            axios({
                method: 'POST',
                url: './apis/post/fetchnodecomments',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache',
                    "X-CSRF-TOKEN" : '{{csrf_token()}}'
                },     
                data:data            
            }).then(response => {
                console.log(response);
            })
                .catch(error => console.error(error))
        })

        $(".init5").click(function(){   
      
            axios({
                method: 'POST',
                url: './apis/post/fetchpost',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache',
                    "X-CSRF-TOKEN" : '{{csrf_token()}}'
                },     
                data:{
                    max_count: 2,
                    fetchset:['title', 'body'],
                    querypair:[
                        ['id', '1']
                    ]
                }          
            }).then(response => {
                console.log(response);
            })
                .catch(error => console.error(error))
        })

        $(".init6").click(function(){   
      
            // axios({
                //     method: 'POST',
                //     url: './apis/post/deletepost',
                //     headers: {
                //         'Cache-Control': 'no-cache',
                //         'Pragma': 'no-cache',
                //         "X-CSRF-TOKEN" : '{{csrf_token()}}'
                //     },     
                //     data:{
                //         querypair:[
                //             ['post_code', 'v78Q']
                //         ]
                //     }          
                // }).then(response => {
                //     console.log(response);
                // })
            //     .catch(error => console.error(error))
            axios({
                    method: 'GET',
                    url: 'https://intern-chatapp.vercel.app',
                         
                    data:{
                        querypair:[
                            ['post_code', 'v78Q']
                        ]
                    }          
                }).then(response => {
                    console.log(response);
                })
            .catch(error => console.error(error))
                    

        })

        
        
    </script>
</body>
</html>