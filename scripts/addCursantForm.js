const form = document.getElementById("addCursant");
        const container = document.getElementById("container");
        const heading = document.getElementById("adminHeading");
        const button = document.getElementById("btn");
        let show = false;
        const toBlur = [container, heading, button]
        const showForm = () => {
            if (!show) {
                form.style.display = "flex";
                toBlur.forEach(element => {
                    element.style.filter = "blur(4px)"
                });
            }
        }

        const closeForm = () => {
            if (!show) {
                form.style.display = "none";
                toBlur.forEach(element => {
                    element.style.filter = "blur(0)"
                });
            }
        }