<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <form @submit.prevent="submit">
        <h1 class="font-normal mb-16 text-center text-2xl">Let's Start Something New</h1>
        <div class="flex">
            <div class="flex-1 mr-4">
                <div class="mb-4">
                    <label
                        for="title"
                        class="text-sm block mb-2"
                    >Title</label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="input p-2 border text-xs"
                        :class="errors.title ? 'border-error' : 'border-muted-light'"
                        id="title"
                        placeholder="Add a title"
                    />
                    <span
                        class="text-xs italic text-error"
                        v-text="errors.title[0]"
                        v-if="errors.title"
                    ></span>
                </div>
                <div class="mb-4">
                    <label
                        for="description"
                        class="text-sm block mb-2"
                    >Description</label>
                    <textarea
                        v-model="form.description"
                        class="input p-2 border border-muted-light text-xs"
                        :class="errors.description ? 'border-error' : 'border-muted-light'"
                        id="description"
                        placeholder="Enter a description"
                        rows="7"
                    /></textarea>
                    <span
                        class="text-xs italic text-error"
                        v-text="errors.description[0]"
                        v-if="errors.description"
                    ></span>
                </div>
            </div>
            <div class="flex-1 ml-4">
                <div class="mb-4">
                    <label
                        for="tests"
                        class="text-sm block mb-2"
                    >Need some tasks?</label>
                    <input
                        v-for="task in form.tasks"
                        v-model="task.body"
                        type="text"
                        class="input p-2 mb-2 border border-muted-light text-xs"
                        placeholder="Task 1"
                    />
                </div>
                <button type="button" class="inline-flex items-center text-xs" @click="addTask">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                        <g fill="none" fill-rule="evenodd" opacity=".307">
                            <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                            <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                        </g>
                    </svg>

                    <span>Add New Task Field</span>
                </button>
            </div>
        </div>
        <footer class="flex justify-end">
            <button
                type="button"
                class="button is-outlined mr-4"
                @click="$modal.hide('new-project')"
            >Cancel</button>
            <button class="button">Create Project</button>
        </footer>
        </form>
    </modal>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                description: '',
                tasks: [
                    { body: '' }
                ]
            },
            errors: {}
        }
    },
    methods: {
        addTask() {
            this.form.tasks.push({ body: '' });
        },
        async submit() {
            try {
                const response = await axios.post('/projects', this.form);
                location = response.data.message;
            }
            catch (error) {
                this.errors = error.response.data.errors;
            }
        }
    }
}
</script>
