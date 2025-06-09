import React, { useEffect, useState } from 'react';

import { shuffle } from './../../utils/shuffle.js';

const TIMEOUT = 1900;

export const Example = ({ content = '' }) => {
	const allEmojis = ['✨', '💫', '💛', '🌙', '⚡️'];

	const [emojis, setEmojis] = useState(allEmojis.slice(0, 3));

	useEffect(() => {
		const id = setInterval(() => {
			setEmojis(shuffle(allEmojis).slice(0, 3));
		}, TIMEOUT);

		return () => clearInterval(id);
	}, []);

	return (
		<div
			className="emojis"
			title={content}
		>
			{emojis.map((_, i) => (
				<span key={i}>
					{_}
				</span>
			))}
		</div>
	);
};

export default Example;
