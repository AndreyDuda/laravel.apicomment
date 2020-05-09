<template>
    <div>
        <add-comment
            v-on:add-comment="addComment"
        />
        <tree
            v-bind:tree="comments"
            v-on:remove-comment="removeComment"
            v-on:emit-reply-comment="emitReplyComment"
            v-on:emit-edit-comment="emitEditComment"
        />
        <reply-comment
            v-on:reply-add-comment="replyAddComment"
            v-bind:comment="commentItem"
        />
        <edit-comment
            v-bind:comment="commentItemEdit"
            v-on:edit-comment="editComment"
        />
    </div>
</template>

<script>
    import AddComment from "./AddComment";
    import Tree from "./Tree";
    import ReplyComment from "./ReplyComment";
    import EditComment from "./EditComment";
    export default {
        data: function () {
           return {
              comments: {},
              commentItem: {},
              commentItemEdit: {}
           }
        },
        mounted() {
            this.loadComments()
        },
        methods: {
            loadComments: function () {
                this.is_load = true
                axios.get('/api/comment').then((response) => {
                    this.comments = response.data.data
                    this.is_load = false;
                });
            },
            removeComment(id) {
                this.comments = this.removeItem(this.comments, id);
            },
            addComment(submitData) {
                this.comments.unshift(submitData)
            },

            editComment(editCommentData) {
                this.comments = this.editItem(this.comments, editCommentData);
            },
            removeItem(object, id) {
                for (var item in object) {
                    if (object[item].replies) {
                        object[item].replies = this.removeItem(object[item].replies, id)
                    }
                }
                return object.filter(c => c.id !== id);
            },

            editItem(object, editCommentData){
                for (var item in object) {
                    if (object[item].id != editCommentData.id && object[item].replies != undefined) {
                        object[item] = this.editItem(object[item].replies, editCommentData)
                    } else if (object[item].id == editCommentData.id) {
                        object[item].author_name = editCommentData.author_name;
                        object[item].text = editCommentData.text;
                        return  object;
                    }
                }
                return  object;
            },

            replyAddComment(replyCommentData) {
                this.comments = this.putItem(this.comments, replyCommentData);
            },
            putItem(object, replyCommentData) {
                for (var item in object) {
                    if (object[item].id != replyCommentData.parent_id && object[item].replies != undefined) {
                        object[item].replies = this.putItem(object[item].replies, replyCommentData);
                    } else if (object[item].id == replyCommentData.parent_id) {
                        object[item].replies.push(replyCommentData);
                        return object;
                    }
                }
                return object;
            },

            emitEditComment(commentData) {
                this.commentItemEdit = commentData;
            },
            emitReplyComment(commentData) {
                this.commentItem = commentData;
            },
        },
        components: {
            ReplyComment,
            AddComment,
            EditComment,
            Tree
        }
    }
</script>
<style>
    .tree-list {
        padding-left: 16px;
        margin: 6px 0;
    }
</style>
