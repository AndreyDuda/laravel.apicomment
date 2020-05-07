<template>
    <div class="card">
        <button @click="edit" class="btn btn-default mb-1">Редактировать</button>
        <button @click="del" class="btn btn-default mb-1">Удалить</button>
        <div class="card-body comment-body ">
            Hello, Teilor.
        </div>
        <button @click="reply" class="btn btn-default mb-1" >Ответить</button>
    </div>
</template>

<script>
    export default {
        data: function () {
           return {
               comments: [],
               is_load: false
           }
        },
        mounted() {
            console.log('Component mounted.'),
            this.update()
            this.reply()
            this.edit()
            this.del()
        },
        methods: {
            update: function () {
                this.is_load = true
                axios.get('/api/comment').then((response) => {
                    console.log(response)
                    this.comments = response.data
                    this.is_load = false;
                });
            },
            reply: function () {
                console.log('update')
            },
            edit: function () {
                console.log('edit')
            },
            del: function () {
                console.log('delete')
            }
        }
    }
</script>
