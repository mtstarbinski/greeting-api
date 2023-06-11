import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { TextControl, PanelBody, Button } from "@wordpress/components";
import {
	RichText,
	InspectorControls,
	useBlockProps,
} from "@wordpress/block-editor";
import block from "./block.json";

registerBlockType(block.name, {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { greeting, wordpressUrl, clientId, clientSecret } = attributes;

		function changeMessage(value) {
			setAttributes({ greeting: value });
		}
		function changeUrl(value) {
			setAttributes({ wordpressUrl: value });
		}
		function changeClientId(value) {
			setAttributes({ clientId: value });
		}
		function changeClientSecret(value) {
			setAttributes({ clientSecret: value });
		}
		function handleSend() {
			let data = greeting;

			fetch(wordpressUrl + "/wp-json/gapi/v1/greeting?greeting=" + data, {
				method: "POST",
				headers: {
					"Content-Type": "application/json; charset=UTF-8",
					"client-id": clientId,
					"client-secret": clientSecret,
				},
			})
				.then((res) => {
					if (res.status === 404) {
						alert("Bad Url!");
					} else if (res.status === 401) {
						alert("Incorrect Client ID or Secret!");
					} else {
						alert("Request complete!");
						setAttributes({ greeting: "" });
						setAttributes({ wordpressUrl: "" });
						setAttributes({ clientId: "" });
						setAttributes({ clientSecret: "" });
					}
				})
				.catch((err) => {
					alert(err);
				});
		}

		return (
			<>
				<InspectorControls>
					<PanelBody title={__("API")}>
						<TextControl
							label="WordPress URL"
							name="wordpressUrl"
							placeholder="https://site.com"
							value={wordpressUrl}
							onChange={changeUrl}
						/>
						<TextControl
							label="OAuth2 Client ID"
							name="clientId"
							value={clientId}
							onChange={changeClientId}
						/>

						<TextControl
							label="OAuth2 Client Secret"
							name="clientSecret"
							value={clientSecret}
							onChange={changeClientSecret}
						/>
					</PanelBody>
				</InspectorControls>

				<div {...blockProps}>
					<TextControl
						name="greeting"
						onChange={changeMessage}
						value={greeting}
						placeholder="Write greeting..."
						style={{ display: "block", marginBottom: "20px" }}
					/>
					<Button variant="primary" onClick={handleSend}>
						Send Greeting
					</Button>
				</div>
			</>
		);
	},
	save: () => {
		return null;
	},
});
