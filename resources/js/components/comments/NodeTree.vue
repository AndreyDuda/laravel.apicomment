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
                <button type="button" class="btn btn-link btn-sm right" @click="emitReplyComment(node.id)" data-toggle="modal" data-target="#replyForm">
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
        data() {
          return {
              csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        },
        props: {
            node: {}
        },
        methods: {
            removeComment(id) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrf
                axios.delete('/api/comment/' + id, {id:id}, {Accept: 'application/json'}).then((response) => {
                    this.$emit('remove-comment', id)
                });
            },
            emitEditComment(comment) {
                this.$emit('emit-edit-comment', comment)

            },
            emitReplyComment(comment) {
                this.$emit('emit-reply-comment', comment)
            },
            isErrorId(object) {
                return (object.id == undefined) ? true : false;
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
    /*.deleteted{
        display: none;
    }*/

</style>
