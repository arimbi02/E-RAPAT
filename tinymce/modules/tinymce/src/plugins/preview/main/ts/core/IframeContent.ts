import { Link } from '@ephox/sugar';

import Editor from 'tinymce/core/api/Editor';
import Tools from 'tinymce/core/api/util/Tools';

import * as Options from '../api/Options';

const getPreviewHtml = (editor: Editor): string => {
  let headHtml = '';
  const encode = editor.dom.encode;
  const contentStyle = Options.getContentStyle(editor) ?? '';

  headHtml += `<base href="${encode(editor.documentBaseURI.getURI())}">`;

  const cors = Options.shouldUseContentCssCors(editor) ? ' crossorigin="anonymous"' : '';
  Tools.each(editor.contentCSS, (url) => {
    headHtml += '<link type="text/css" rel="stylesheet" href="' + encode(editor.documentBaseURI.toAbsolute(url)) + '"' + cors + '>';
  });

  if (contentStyle) {
    headHtml += '<style type="text/css">' + contentStyle + '</style>';
  }

  const bodyId = Options.getBodyId(editor);

  const bodyClass = Options.getBodyClass(editor);

  const directionality = editor.getBody().dir;
  const dirAttr = directionality ? ' dir="' + encode(directionality) + '"' : '';

  const previewHtml = (
    '<!DOCTYPE html>' +
    '<html>' +
    '<head>' +
    headHtml +
    '</head>' +
    '<body id="' + encode(bodyId) + '" class="mce-content-body ' + encode(bodyClass) + '"' + dirAttr + '>' +
    editor.getContent() +
    Link.getPreventClicksOnLinksScript() +
    '</body>' +
    '</html>'
  );

  return previewHtml;
};

export {
  getPreviewHtml
};
