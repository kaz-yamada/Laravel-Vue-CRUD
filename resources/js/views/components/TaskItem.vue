<template>
  <div class="flex items-center h-10 my-3">
    <div v-if="isEditing" class="flex w-full h-10 mr-2">
      <input
        type="text"
        class="border-2 border-gray-200 rounded-lg w-full p-2"
        v-model="newTaskName"
      />
    </div>
    <label
      v-else
      class="flex justify-start bg-white hover:bg-gray-200 items-center cursor-pointer w-full h-10 mr-2"
    >
      <div
        class="bg-white border-2 rounded border-gray-400 w-6 h-6 flex flex-shrink-0 justify-center items-center mx-2 cursor-pointer"
      >
        <input
          type="checkbox"
          v-model="task.completed"
          @change="toggleTaskStatus"
          class="opacity-0 absolute"
        />
        <CheckIcon
          :class="[task.completed ? 'block' : 'hidden']"
          class="text-green-500 cursor-pointer"
        />
      </div>
      <div :class="[task.completed ? 'line-through text-gray-400' : '']">
        {{ task.name }}
      </div>
    </label>
    <template v-if="isEditing">
      <button
        class="bg-green-500 hover:bg-green-700 text-white mr-2"
        @click="updateTaskName"
      >
        <SaveIcon />
      </button>
      <button
        @click="cancelEdit"
        class="bg-yellow-500 hover:bg-yellow-700 text-white"
      >
        <XIcon />
      </button>
    </template>
    <template v-else>
      <button
        @click="toggleEditing"
        class="bg-blue-500 hover:bg-blue-700 text-white mr-2"
      >
        <PencilIcon />
      </button>
      <button
        @click="removeTask"
        class="bg-red-500 hover:bg-red-700 text-white"
      >
        <TrashIcon />
      </button>
    </template>
  </div>
</template>

<script>
import {
  CheckIcon,
  PencilIcon,
  TrashIcon,
  SaveIcon,
  XIcon,
} from "@vue-hero-icons/outline";

export default {
  components: {
    CheckIcon,
    PencilIcon,
    TrashIcon,
    SaveIcon,
    XIcon,
  },
  data: function () {
    return {
      isEditing: false,
      newTaskName: this.task.name,
    };
  },
  props: ["task"],
  methods: {
    toggleTaskStatus() {
      axios
        .put(`api/task/${this.task.id}`, { task: this.task })
        .then((res) => {
          if (res.status === 200) {
            this.$emit("taskupdated");
          }
        })
        .catch((err) => console.error(err));
    },
    toggleEditing() {
      this.isEditing = true;
    },
    updateTaskName() {
      if (this.newTaskName !== "" && this.newTaskName !== this.task.name) {
        axios
          .put(`api/task/${this.task.id}`, {
            task: { ...this.task, name: this.newTaskName },
          })
          .then((res) => {
            if (res.status === 200) {
              this.$emit("taskupdated");
              this.isEditing = false;
            }
          })
          .catch((err) => console.error(err));
      } else {
        cancelEdit();
      }
    },
    cancelEdit() {
      this.isEditing = false;
    },
    removeTask() {
      axios
        .delete(`api/task/${this.task.id}`)
        .then((res) => {
          if (res.status === 200) {
            this.$emit("taskupdated");
          }
        })
        .catch((err) => console.error(err));
    },
  },
};
</script>
 