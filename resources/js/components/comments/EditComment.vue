<template>
    <div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <input type="name" class="form-control" v-model="comment.author_name" placeholder="Имя/НИК" value="message">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Оставьте комментарий" rows="3" v-model="comment.text"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" data-dismiss="modal" @click.prevent="onSubmitEdit">Редактировать</button>
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
            comment: {}
        },
        methods: {
            onSubmitEdit() {
                var editCommentData = {
                    id: this.comment.id,
                    post_id: 1,
                    author_name: this.comment.author_name,
                    text: this.comment.text
                };
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf
                axios.post('/api/comment', editCommentData, {Accept: 'application/json'}).then((response) => {
                    this.author_name = '';
                    this.text = '';
                    this.$emit('add-comment', response.data);
                });

            }
        }
    }
</script>
