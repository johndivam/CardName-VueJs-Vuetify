import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


export async function generateCardNameService(form, isPending, root){
    isPending.value = true;

    try {
        const response = await axios.post('/api/generateCardNameService',{
            'name':form.name,
            'id':form.id,
            'img':form.img
        });
    


    if(response.status=== 200){
        toast.success(response.data.message, {
            position: "top-right",
            autoClose: 3000,
        });

        const link = document.createElement('a');
        link.href = response.data.imagesrc;
        link.download = response.data.imagename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    
    } catch ({response}) {
        if(response.status===401){
        toast.error(response.data.message, {
            position: "top-right",
            autoClose: 3000,
        });
    }
    else if(response.status==422){
        for(let i in response.data.errors){
            toast.warning(response.data.errors[i][0], {
                position: "top-right",
                autoClose: 3000,
            });
        }
    } 
    else{
        toast.error("Somethingn went wrong! Please try again.", {
            position: "top-right",
            autoClose: 3000,
            //rtl: false
        });
    }
    }

    isPending.value = false;
}