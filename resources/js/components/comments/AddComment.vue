<template>
    <div>
        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <input type="name" class="form-control" v-model="author_name" placeholder="Имя/НИК" value="message">
            </div>
            <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Оставьте комментарий" rows="3" v-model="text"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
            </form>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                author_name: '',
                text: ''
            }
        },
        methods: {
            onSubmit() {
                var submitData = {
                    author_name: this.author_name,
                    text: this.text,
                    post_id: 1
                };
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf
                axios.post('/api/comment', submitData, {Accept: 'application/json'}).then((response) => {
                    this.author_name = '';
                    this.text = '';
                    this.$emit('add-comment', response.data);
                });
            }
        }
    }
</script>
