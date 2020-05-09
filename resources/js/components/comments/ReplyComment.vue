<template>
    <div>
        <div class="modal fade" id="replyForm" tabindex="-1" role="dialog" aria-labelledby="replyFormLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyFormLabel">Ответ для {{comment.author_name}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <input type="name" class="form-control" v-model="author_name" placeholder="Имя/НИК" value="message">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Оставьте комментарий" rows="3" v-model="text"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" @click="onSubmitReply()">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "comment",
        props: {
            comment: {},
        },
        data() {
            return {
                author_name: '',
                text: ''
            }
        },
        methods: {
            onSubmitReply() {
                var replyCommentData = {
                    post_id: 1,
                    parent_id: this.comment.id,
                    author_name:this.author_name,
                    text: this.text
                };

                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf
                axios.post('/api/comment', replyCommentData, {Accept: 'application/json'}).then((response) => {
                    this.author_name = '';
                    this.text = '';
                    this.$emit('reply-add-comment', response.data);
                });
            },
            clearForm() {
                this.author_name = '';
                this.text = '';
            }
        }
    }
</script>
