<template>
    <li class="node-tree">
        <div class="card" >
            <div class="card-body">
                <button type="button" class="btn btn-dark btn-sm right" @click="removeComment(node.id)">delete</button>
                <button type="button" class="btn btn-light btn-sm right" @click="emitEditComment(node)" data-toggle="modal" data-target="#exampleModal">
                    edit
                </button>
                <h5 class="card-title">{{ node.author_name }}</h5>
                <div>{{ node.text }}</div>
                <button type="button" class="btn btn-link btn-sm right" @click="emitReplyComment(node)" data-toggle="modal" data-target="#replyForm">
                    reply
                </button>
            </div>
        </div>
       <ul v-if="node.replies">
            <node
                v-for="replies in node.replies"
                v-bind:node="replies"
                v-on:remove-comment="removeComment"
                v-on:emit-reply-comment="emitReplyComment"
                v-on:emit-edit-comment="emitEditComment"
            />
        </ul>
    </li>
</template>

<script>
    export default {
        name: "node",
        props: {
            node: {}
        },
        methods: {
            removeComment(id) {
                this.$emit('remove-comment', id)
            },
            emitEditComment(comment) {
                this.$emit('emit-edit-comment', comment)

            },
            emitReplyComment(comment) {
                this.$emit('emit-reply-comment', comment)
            }
        }
    };
</script>
<style scoped>
    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .right {
        float: right;
    }
</style>
