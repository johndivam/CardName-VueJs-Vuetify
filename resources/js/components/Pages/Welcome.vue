<template>
  <AppLayout>
    <template #content>
        <section class="header">
            <div class="container">
              <h2 class="text-center">
                Ead Card | Make Your Own Card
              </h2>
            </div>
        </section>
        <section class="cards">
          <div class="container">
            <div class="row">
              <div class="col-3" v-for="card in cards" :key="card.id">
                 <div class="card">
                    <img @click="openModal(card)" :src="card.img" class="img-thumbnail">
                 </div>
              </div>
            </div>
          </div>
        </section>
    </template>

    <template #footer>    
    <v-dialog v-model="showDialog" width="800" scrollable>
      <v-form ref="myform" v-model="valid" :lazy-validation="false">
        <v-card>
          <v-card-title>
            Card Name 
          </v-card-title>
          <v-card-text style="bg-color:red">
            <img :src="form.img" class="mx-auto d-block shadow" height="400" >
            <v-text-field  
            label="Enter Your Name" 
            v-model="form.name"  
            variant="outlined" 
            prepend-inner-icon="mdi-account-outline"
            class="mt-3"
            :rules="[required,name]"
            ></v-text-field>
          </v-card-text>
          <v-card-actions class="justify-end pr-6 pt-0" >
            <v-btn @click="showDialog = false"  color="grey-lighten-3" variant="flat">Cancel</v-btn>
            <v-btn type="submit"  :disabled="!valid" :loading="isPending"  
              @click.prevent="generateCardName" color="indigo-darken-3" variant="flat" >Submit
            </v-btn>
          </v-card-actions>
        </v-card>
        </v-form>
      </v-dialog>
    </template>
  </AppLayout>

</template>


<script>
import { computed, reactive, ref, getCurrentInstance, watchEffect } from "vue";
import AppLayout from "@/components/Layouts/AppLayout.vue"
import {generateCardNameService}  from "@/services/GenerateCardNameService.js"
import { required, name} from "@/Mixins/Validations.js";

export default {
  watch: {
  },
    name:"Welcome",
    components:{
        AppLayout,
    },
    data() {
        return {
        valid: false,
        };
    },
    setup() {
      const root = getCurrentInstance().proxy;

      const cards = [
        {id:1 ,"img":"assets/images/cards/card1.jpg"},
        {id:2 ,"img":"assets/images/cards/card2.jpg"},
        {id:3 ,"img":"assets/images/cards/card3.jpg"},
        {id:5 ,"img":"assets/images/cards/card5.jpg"},
        {id:6 ,"img":"assets/images/cards/card6.jpg"},
        {id:7 ,"img":"assets/images/cards/card7.jpg"},
        {id:8 ,"img":"assets/images/cards/card8.webp"},
        {id:9 ,"img":"assets/images/cards/card9.jpg"},
        {id:10,"img":"assets/images/cards/card10.png"},
        {id:11,"img":"assets/images/cards/card11.webp"},
        {id:12,"img":"assets/images/cards/card12.webp"},
      ]

      const showDialog = ref(false);
      const isPending = ref(false);
        const form  = reactive({
            id:0,
            img:'',
            name:'',
        });

      const openModal = (card)=> {
        form.id = card.id;
        form.img = card.img;
        showDialog.value = true;
      }
      const closeModal = ()=> {
        showDialog.value = false;
      }

     
     
      const generateCardName = async() => {
          if (isPending.value) return;
          generateCardNameService(form, isPending, root)
      };
        
      return {
          cards,
          showDialog,
          openModal,
          closeModal,
          form,
          generateCardName,
          isPending,
          required: (value) => required(value),
          name: (value) => name(value),
      };
    },
}
</script>
