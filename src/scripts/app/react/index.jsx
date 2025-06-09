import React from 'react';
import { createRoot } from 'react-dom/client';

import Example from './Example.jsx';

const SELECTOR_ROOT = '.js-root-container';

export const init = () => {
	const domNode = document.querySelector(SELECTOR_ROOT);

	if (domNode) {
		const root = createRoot(domNode);

		const {
			content,
		} = domNode.dataset;

		root.render(
			<Example content={content} />,
		);
	}
};

document.addEventListener('DOMContentLoaded', init);

export default {
	init,
};
