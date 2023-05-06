let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector("#main");
toggle.addEventListener("click", function () {
	toggle.classList.toggle("active");
	navigation.classList.toggle("active");
	main.classList.toggle("active");
});
function reviewImage(id1, id2) {
	let fileInputIm = id1;
	let imageElementIm = id2;

	fileInputIm.addEventListener("change", (event) => {
		const selectedFile = event.target.files[0];
		const reader = new FileReader();

		reader.addEventListener("load", () => {
			imageElementIm.src = reader.result;
		});

		reader.readAsDataURL(selectedFile);
	});
}

function reviewGallery(id1, id2) {
	const galleryIm = id1;
	const previewIm = id2;

	galleryIm.addEventListener("change", () => {
		previewIm.innerHTML = "";
		let width = 100 / galleryIm.files.length;

		for (const file of galleryIm.files) {
			if (file.type.startsWith("image/")) {
				const readerIm = new FileReader();
				readerIm.readAsDataURL(file);
				readerIm.onload = () => {
					previewIm.innerHTML += `<img style="width:${width}%" src="${readerIm.result}" alt="${file.name}">`;
				};
			} else if (file.type.startsWith("video/")) {
				const videoIm = document.createElement("video");
				videoIm.src = URL.createObjectURL(file);
				videoIm.style.width = width + "%";
				videoIm.controls = true;
				videoIm.addEventListener("loadedmetadata", () => {
					// previewIm.innerHTML += `<p>${file.name} (Duration: ${video.duration.toFixed(2)} seconds)</p>`;
					previewIm.appendChild(videoIm);
				});
			} else if (file.type.startsWith("audio/")) {
				const audioIM = document.createElement("audio");
				audioIM.src = URL.createObjectURL(file);
				audioIM.style.width = width + "%";
				audioIM.controls = true;
				audioIM.addEventListener("loadedmetadata", () => {
					previewIm.appendChild(audioIM);
				});
			}
		}
	});
}
