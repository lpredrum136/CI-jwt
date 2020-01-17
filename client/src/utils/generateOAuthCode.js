const generateOAuthCode = (length, charArr) => {
	let result = '';
	for (let i = length; i > 0; i--) {
		result += charArr[Math.floor(Math.random() * charArr.length)];
	}
	return result;
};

export default generateOAuthCode;
