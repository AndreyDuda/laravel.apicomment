<template>
    <div class="tree">
        <ul class="tree-list">
            <node-tree
                v-for="item of tree"
                v-bind:node="item"
                v-on:remove-comment="removeComment"
                v-on:emit-reply-comment="emitReplyComment"
                v-on:emit-edit-comment="emitEditComment"
            />
        </ul>
    </div>
</template>

<script>
    import EditComment from "./EditComment";
    import NodeTree from "./NodeTree";
    import ReplyComment from "./ReplyComment"

    export default {
        props: {
            tree: {}
        },
        components: {
            NodeTree,
            ReplyComment,
            EditComment
        },
        methods: {
            removeComment(id) {
                this.$emit('remove-comment', id);
            },
            emitReplyComment(commentData) {
                this.$emit('emit-reply-comment', commentData)
            },
            emitEditComment(commentData){
                this.$emit('emit-edit-comment', commentData)
            }

        }
    };
</script>

<style>
    .tree-list ul {
        padding-left: 16px;
        margin: 6px 0;
    }
</style>
