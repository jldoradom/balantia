document.onreadystatechange = () => {
    if(document.readyState === 'complete'){
        window.livewire.on('file_upload_start', () => {
            try{
                let file = event.target.files[0];
                if(file){
                    console.log(file);
                    let reader = new FileReader();
                    reader.onloadend = () => {
                        window.livewire.emit('csvhandleFileUploaded', {
                            data: reader.result,
                            filename: file.name,
                        });
                    }

                    reader.readAsDataURL(file);
                }
            } catch(e) {
                console.log(e);
            }
        });
    }
}
